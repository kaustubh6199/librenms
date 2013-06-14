﻿describe('removeLayer', function () {
	var map, div, clock;
	beforeEach(function () {
		clock = sinon.useFakeTimers();
		div = document.createElement('div');
		div.style.width = '200px';
		div.style.height = '200px';
		document.body.appendChild(div);

		map = L.map(div, { maxZoom: 18 });

		map.fitBounds(new L.LatLngBounds([
			[1, 1],
			[2, 2]
		]));
	});
	afterEach(function () {
		clock.restore();
		document.body.removeChild(div);
	});

	it('removes a layer that was added to it', function () {

		var group = new L.MarkerClusterGroup();
		var marker = new L.Marker([1.5, 1.5]);

		map.addLayer(group);

		group.addLayer(marker);

		expect(marker._icon.parentNode).to.be(map._panes.markerPane);

		group.removeLayer(marker);

		expect(marker._icon).to.be(null);
	});

	it('doesnt remove a layer not added to it', function () {

		var group = new L.MarkerClusterGroup();
		var marker = new L.Marker([1.5, 1.5]);

		map.addLayer(group);

		map.addLayer(marker);

		expect(marker._icon.parentNode).to.be(map._panes.markerPane);

		group.removeLayer(marker);

		expect(marker._icon.parentNode).to.be(map._panes.markerPane);
	});

	it('removes a layer that was added to it (before being on the map) that is shown in a cluster', function () {

		var group = new L.MarkerClusterGroup();
		var marker = new L.Marker([1.5, 1.5]);
		var marker2 = new L.Marker([1.5, 1.5]);

		group.addLayers([marker, marker2]);
		map.addLayer(group);

		group.removeLayer(marker);

		expect(marker._icon).to.be(undefined);
		expect(marker2._icon.parentNode).to.be(map._panes.markerPane);
	});

	it('removes a layer that was added to it (after being on the map) that is shown in a cluster', function () {

		var group = new L.MarkerClusterGroup();
		var marker = new L.Marker([1.5, 1.5]);
		var marker2 = new L.Marker([1.5, 1.5]);

		map.addLayer(group);
		group.addLayer(marker);
		group.addLayer(marker2);

		group.removeLayer(marker);

		expect(marker._icon).to.be(null);
		expect(marker2._icon.parentNode).to.be(map._panes.markerPane);
	});

	it('removes a layer that was added to it (before being on the map) that is individually', function () {

		var group = new L.MarkerClusterGroup();
		var marker = new L.Marker([1, 1.5]);
		var marker2 = new L.Marker([3, 1.5]);

		map.addLayer(group);
		group.addLayer(marker);
		group.addLayer(marker2);

		expect(marker._icon.parentNode).to.be(map._panes.markerPane);
		expect(marker2._icon.parentNode).to.be(map._panes.markerPane);

		group.removeLayer(marker);

		expect(marker._icon).to.be(null);
		expect(marker2._icon.parentNode).to.be(map._panes.markerPane);
	});

	it('removes a layer (with animation) that was added to it (after being on the map) that is shown in a cluster', function () {

		var group = new L.MarkerClusterGroup({ animateAddingMarkers: true });
		var marker = new L.Marker([1.5, 1.5]);
		var marker2 = new L.Marker([1.5, 1.5]);

		map.addLayer(group);
		group.addLayer(marker);
		group.addLayer(marker2);

		//Run the the animation
		clock.tick(1000);

		expect(marker._icon).to.be(null);
		expect(marker2._icon).to.be(null);

		group.removeLayer(marker);

		//Run the the animation
		clock.tick(1000);

		expect(marker._icon).to.be(null);
		expect(marker2._icon.parentNode).to.be(map._panes.markerPane);
	});
});