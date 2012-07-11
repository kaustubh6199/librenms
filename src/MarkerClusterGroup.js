
/*
 * L.MarkerClusterGroup extends L.FeatureGroup by clustering the markers contained within
 */

L.MarkerClusterGroup = L.FeatureGroup.extend({

	options: {
		//distanceToCluster: 10, //Any points closer than this will probably get put in to a cluster
		maxClusterRadius: 60, //A cluster will cover at most this many pixels from its center
		iconCreateFunction: function (childCount) {
			var c = ' marker-cluster-';
			if (childCount < 10) {
				c += 'small';
			} else if (childCount < 100) {
				c += 'medium';
			} else {
				c += 'large';
			}

			return new L.DivIcon({ html: '<div><span>' + childCount + '</span></div>', elementType: 'span', className: 'marker-cluster' + c, iconSize: new L.Point(40, 40) });
		}
	},

	initialize: function (options) {
		L.Util.setOptions(this, options);

		L.FeatureGroup.prototype.initialize.call(this, []);

		this._needsClustering = [];

		this._markersAndClustersAtZoom = {};
	},


	_sqDist: function (p1, p2) {
		var dx = p2.x - p1.x,
			dy = p2.y - p1.y;
		return dx * dx + dy * dy;
	},

	_zoomEnd: function () {
		this._animationStart();

		this._mergeSplitClusters();

		this._zoom = this._map._zoom;
	},

	_moveEnd: function () {
		if (this._inZoomAnimation) {
			return;
		}

		var l, i,
		    layers = this._layers,
		    bounds = this._getExpandedVisibleBounds(),
		    highestLevel = this._markersAndClustersAtZoom[this._highestZoom],
		    depth = this._zoom - this._highestZoom,
		    highestLevelClusters = highestLevel.clusters,
		    highestLevelUnclustered = highestLevel.unclustered;

		//Remove visible layers that are no longer visible
		for (i in layers) {
			l = layers[i];
			if (!bounds.contains(l.getLatLng())) {
				L.FeatureGroup.prototype.removeLayer.call(this, l);
			}
		}

		//Re-Check everyone for being in the viewport
		//Do the clusters (and their child unclustered ones) recursively for performance
		for (i = 0; i < highestLevelClusters.length; i++) {
			l = highestLevelClusters[i];
			if (bounds.contains(l.getLatLng())) {
				l._recursivelyAddChildrenToMap(null, depth, bounds);
			}
		}

		//Do the markers at this level too
		for (i = 0; i < highestLevelUnclustered.length; i++) {
			l = highestLevelUnclustered[i];
			if (bounds.contains(l.getLatLng())) {
				L.FeatureGroup.prototype.addLayer.call(this, l);
			}
		}
	},

	_generateInitialClusters: function () {
		var res = this._cluster(this._needsClustering, [], this._map.getZoom());

		this._markersAndClustersAtZoom[this._map._zoom] = res;
		//Remember the highest zoom level we've seen and the current zoom level
		this._highestZoom = this._zoom = this._map._zoom;

		//Make things appear on the map
		for (var i = 0; i < res.clusters.length; i++) {
			res.clusters[i]._addToMap();
		}
		for (var j = 0; j < res.unclustered.length; j++) {
			L.FeatureGroup.prototype.addLayer.call(this, res.unclustered[j]);
		}
	},

	//Merge and split any existing clusters that are too big or small
	_mergeSplitClusters: function () {
		var map = this._map,
			newState,
		    depth = Math.abs(this._map._zoom - this._zoom);

		if (this._zoom < this._map._zoom) { //Zoom in, split
			var startingClusters = this._markersAndClustersAtZoom[this._zoom].clusters;

			while (this._zoom < this._map._zoom) { //Split each intermediate layer if required
				var currentClusters = this._markersAndClustersAtZoom[this._zoom].clusters;

				this._zoom++;

				newState = this._markersAndClustersAtZoom[this._zoom];

				if (!newState) { //If we don't have clusters for the new level, calculate them
					newState = { 'clusters': [], 'unclustered': [] };

					for (var i = 0; i < currentClusters.length; i++) {
						var newClusters;
						if (currentClusters[i]._childClusters.length > 0) {

							//Child clusters should always be 0 as we haven't calculated clusters for this level
							throw 'something is wrong, childClusters length should be 0: ' + currentClusters[i]._childClusters.length;
						} else {
							newClusters = this._cluster(currentClusters[i]._markers, [], this._zoom);
						}

						currentClusters[i]._childClusters = newClusters.clusters;
						currentClusters[i]._markers = newClusters.unclustered;

						newState.clusters = newState.clusters.concat(newClusters.clusters);
						newState.unclustered = newState.unclustered.concat(newClusters.unclustered);
					}

					this._markersAndClustersAtZoom[this._zoom] = newState;
				}
			}

			this._animationZoomIn(startingClusters, depth);

		} else if (this._zoom > this._map._zoom) { //Zoom out, merge
			this._highestZoom = Math.min(this._highestZoom, this._map._zoom);

			//Ensure all of the intermediate zoom levels are generated
			var now;
			while (this._zoom > this._map._zoom) {
				now = this._markersAndClustersAtZoom[this._zoom];
				newState = this._markersAndClustersAtZoom[this._zoom - 1];
				this._zoom--;

				if (!newState) {
					newState = this._cluster(now.clusters.concat(now.unclustered), [], this._zoom);
					this._markersAndClustersAtZoom[this._zoom] = newState;
				}
			}

			this._animationZoomOut(newState.clusters, depth);
		}
	},

	addLayer: function (layer) {
		this._needsClustering.push(layer);

		//TODO: If we have already clustered we'll need to add this one to a cluster
		//Should be able to use _cluster with the current clusters and just this layer

		return this;
	},

	removeLayer: function (layer) {

		//TODO Hrm....
		//Will need to got through each cluster and find the marker, removing it as required, possibly turning its parent from a cluster into an individual marker.
		//Or the easy version: Just recluster everything!

		return this;
	},

	onAdd: function (map) {
		L.FeatureGroup.prototype.onAdd.call(this, map); // LayerGroup

		this._generateInitialClusters();
		this._map.on('zoomend', this._zoomEnd, this);
		this._map.on('moveend', this._moveEnd, this);
	},

	//Takes a list of objects that have a 'getLatLng()' function (Marker / MarkerCluster)
	//Performs clustering on them (using a greedy algorithm) and returns those clusters.
	//Returns { clusters: [], unclustered: [] }
	_cluster: function (points, existingClusters, zoom) {
		var clusterRadiusSqrd = this.options.maxClusterRadius * this.options.maxClusterRadius,
		    clusters = existingClusters,
		    unclustered = [],
		    center = this._map.getCenter(),
		    i, j, c;

		//Calculate pixel positions
		for (i = 0; i < clusters.length; i++) {
			c = clusters[i];
			c._projCenter = this._map.project(c.getLatLng(), zoom);
		}

		for (i = 0; i < points.length; i++) {
			var p2 = points[i];
			p2._projCenter = this._map.project(p2.getLatLng(), zoom);
		}


		//go through each point
		for (i = 0; i < points.length; i++) {
			var point = points[i];

			var used = false;

			//try add it to an existing cluster
			for (j = 0; j < clusters.length; j++) {
				c = clusters[j];
				if (this._sqDist(point._projCenter, c._projCenter) <= clusterRadiusSqrd) {
					c._addChild(point);
					c._projCenter = this._map.project(c.getLatLng(), zoom);

					used = true;
					break;
				}
			}

			//otherwise, look through all of the markers we haven't managed to cluster and see if we should form a cluster with them
			if (!used) {
				for (j = 0 ; j < unclustered.length; j++) {
					if (this._sqDist(point._projCenter, unclustered[j]._projCenter) <= clusterRadiusSqrd) {
						//Create a new cluster with these 2
						var newCluster = new L.MarkerCluster(this, point, unclustered[j]);
						clusters.push(newCluster);

						newCluster._projCenter = this._map.project(newCluster.getLatLng(), zoom);

						unclustered.splice(j, 1);
						used = true;
						break;
					}
				}
				if (!used) {
					unclustered.push(point);
				}
			}
		}

		//Any clusters that did not end up being a child of a new cluster, make them a child of a new cluster
		for (i = unclustered.length - 1; i >= 0; i--) {
			c = unclustered[i];
			delete c._projCenter;

			if (c instanceof L.MarkerCluster) {
				var nc = new L.MarkerCluster(this, c);
				clusters.push(nc);
				unclustered.splice(i, 1);
			}
		}

		//Remove the _projCenter temp variable from clusters
		for (i = 0; i < clusters.length; i++) {
			delete clusters[i]._projCenter;
			clusters[i]._baseInit();
		}

		return { 'clusters': clusters, 'unclustered': unclustered };
	},

	//Gets the maps visible bounds expanded in each direction by the size of the screen (so the user cannot see an area we do not cover in one pan)
	_getExpandedVisibleBounds: function () {
		var map = this._map,
			bounds = map.getPixelBounds(),
			width = 0,//Math.abs(bounds.max.x - bounds.min.x),
			height = 0,//Math.abs(bounds.max.y - bounds.min.y),
			sw = map.unproject(new L.Point(bounds.min.x - width, bounds.min.y - height)),
			ne = map.unproject(new L.Point(bounds.max.x + width, bounds.max.y + height));
		
		return new L.LatLngBounds(sw, ne);
	}
});

L.MarkerClusterGroup.include(!L.DomUtil.TRANSITION ? {

	//Non Animated versions of everything
	_animationStart: function () {
		//Do nothing...
	},
	_animationZoomIn: function (startingClusters, depth) {
		var bounds = this._getExpandedVisibleBounds();

		//Add all children of current clusters to map and remove those clusters from map
		for (var j = 0; j < startingClusters.length; j++) {
			var c = startingClusters[j];

			//Remove old cluster
			L.FeatureGroup.prototype.removeLayer.call(this, c); //TODO Animate

			c._recursivelyAddChildrenToMap(null, depth, bounds);
		}
	},
	_animationZoomOut: function (newClusters, depth) {
		var bounds = this._getExpandedVisibleBounds();

		//Just add new and remove old from the map
		for (var j = 0; j < newClusters.length; j++) {
			var cl = newClusters[j];

			if (bounds.contains(cl._latlng)) {
				cl._addToMap();
			}
			cl._recursivelyRemoveChildrenFromMap(depth);
		}
	}
} : {

	//Animated versions here
	_animationStart: function () {
		this._map._mapPane.className += ' leaflet-cluster-anim';
	},
	_animationZoomIn: function (startingClusters, depth) {
		var map = this._map,
		    bounds = this._getExpandedVisibleBounds();

		//Add all children of current clusters to map and remove those clusters from map
		for (var j = 0; j < startingClusters.length; j++) {
			var c = startingClusters[j];
			var startPos = c.getLatLng();

			//Remove old cluster
			L.FeatureGroup.prototype.removeLayer.call(this, c); //TODO Animate

			c._recursivelyAddChildrenToMap(startPos, depth, bounds);
		}

		this._inZoomAnimation = true;
		var me = this;
		//Start up a function to update the positions of the just added clusters/markers
		//This must happen after otherwise they don't get animated
		setTimeout(function () {

			for (var j = 0; j < startingClusters.length; j++) {
				startingClusters[j]._recursivelyRestoreChildPositions(depth);
			}

			setTimeout(function () {
				map._mapPane.className = map._mapPane.className.replace(' leaflet-cluster-anim', '');
				me._inZoomAnimation = false;
			}, 250);
		}, 0);
	},
	_animationZoomOut: function (newClusters, depth) {
		var map = this._map,
		    bounds = this._getExpandedVisibleBounds();

		//Animate all of the markers in the clusters to move to their cluster center point
		for (var i = 0; i < newClusters.length; i++) {
			var c = newClusters[i];

			c._recursivelyAnimateChildrenIn(this._map.latLngToLayerPoint(c.getLatLng()).round(), depth);
		}

		this._inZoomAnimation = true;
		var me = this;
		//TODO: Use the transition timing stuff to make this more reliable
		setTimeout(function () {

			map._mapPane.className = map._mapPane.className.replace(' leaflet-cluster-anim', '');

			for (var j = 0; j < newClusters.length; j++) {
				var cl = newClusters[j];
				if (bounds.contains(cl._latlng)) {
					cl._addToMap();
				}
				cl._recursivelyRemoveChildrenFromMap(depth);
			}
			me._inZoomAnimation = false;
		}, 250);
	}
});