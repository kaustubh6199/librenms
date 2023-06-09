(self.webpackChunk = self.webpackChunk || []).push([
    [773], {
        5377: (t, e, a) => {
            "use strict";
            const n = a(538),
                s = a(7152);
            n.Z.use(s.Z);
            const i = new s.Z({
                    locale: document.querySelector("html").getAttribute("lang"),
                    fallbackLocale: "en",
                    silentFallbackWarn: !0,
                    silentTranslationWarn: !0,
                    messages: window.vuei18nLocales
                }),
                o = a(9010),
                r = a.n(o),
                l = a(1542),
                u = a(9938),
                c = a.n(u),
                d = a(7907),
                p = a.n(d),
                v = a(9283),
                m = a(7611),
                f = a.n(m);
            a(9147), window.Vue = a(538).Z;
            const h = a(5642);
            h.keys().map((function(t) {
                return Vue.component(t.split("/").pop().split(".")[0], h(t).default)
            })), Vue.use(r()), Vue.use(l.ZP), Vue.component("v-select", c()), Vue.component("multiselect", p()), Vue.use(v.ZP), Vue.use(f()), Vue.filter("ucfirst", (function(t) {
                return t ? (t = t.toString()).charAt(0).toUpperCase() + t.slice(1) : ""
            }));
            new Vue({
                el: "#app",
                i18n: i
            })
        },
        9147: (t, e, a) => {
            window._ = a(6486);
            try {
                window.Popper = a(8981).Z
            } catch (t) {}
            window.axios = a(9669), window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
            const n = document.head.querySelector('meta[name="csrf-token"]');
            n ? window.axios.defaults.headers.common["X-CSRF-TOKEN"] = n.content : console.error("CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token"), a(7097)
        },
        6832: (t, e, a) => {
            "use strict";
            a.d(e, {
                Z: () => i
            });
            const n = a(1519),
                s = a.n(n)()((function (t) {
                    return t[1]
                }));
            s.push([t.id, ".accordion-item-trigger-icon[data-v-16b90b68]{transition:transform .2s ease}.accordion-item-trigger.collapsed .accordion-item-trigger-icon[data-v-16b90b68]{transform:rotate(-90deg)}", ""]);
            const i = s
        },
        7612: (t, e, a) => {
            "use strict";
            a.d(e, {
                Z: () => i
            });
            const n = a(1519),
                s = a.n(n)()((function (t) {
                    return t[1]
                }));
            s.push([t.id, ".disable-events[data-v-d23a875a]{pointer-events:none}", ""]);
            const i = s
        },
        1973: (t, e, a) => {
            "use strict";
            a.d(e, {
                Z: () => i
            });
            const n = a(1519),
                s = a.n(n)()((function (t) {
                    return t[1]
                }));
            s.push([t.id, "#settings-search[data-v-c1efd320]{border-radius:4px}#settings-search[data-v-c1efd320]::-webkit-search-cancel-button{-webkit-appearance:searchfield-cancel-button}ul.settings-list[data-v-c1efd320]{list-style-type:none}", ""]);
            const i = s
        },
        3594: (t, e, a) => {
            "use strict";
            a.d(e, {
                Z: () => i
            });
            const n = a(1519),
                s = a.n(n)()((function (t) {
                    return t[1]
                }));
            s.push([t.id, ".tab-content{width:100%}", ""]);
            const i = s
        },
        3485: (t, e, a) => {
            "use strict";
            a.d(e, {
                Z: () => i
            });
            const n = a(1519),
                s = a.n(n)()((function (t) {
                    return t[1]
                }));
            s.push([t.id, ".setting-container[data-v-5ab9fce1]{margin-bottom:10px}", ""]);
            const i = s
        },
        5319: (t, e, a) => {
            "use strict";
            a.d(e, {
                Z: () => i
            });
            const n = a(1519),
                s = a.n(n)()((function (t) {
                    return t[1]
                }));
            s.push([t.id, ".input-group[data-v-588cd6c1]{margin-bottom:3px}.input-group-addon[data-v-588cd6c1]:not(.disabled){cursor:move}", ""]);
            const i = s
        },
        514: (t, e, a) => {
            "use strict";
            a.d(e, {
                Z: () => i
            });
            const n = a(1519),
                s = a.n(n)()((function (t) {
                    return t[1]
                }));
            s.push([t.id, ".input-group[data-v-dcc80002]{margin-bottom:3px}.input-group-addon[data-v-dcc80002]:not(.disabled){cursor:move}", ""]);
            const i = s
        },
        3278: (t, e, a) => {
            "use strict";
            a.d(e, {
                Z: () => i
            });
            const n = a(1519),
                s = a.n(n)()((function (t) {
                    return t[1]
                }));
            s.push([t.id, ".form-control[data-v-66aaec8d]{padding-right:12px}", ""]);
            const i = s
        },
        5544: (t, e, a) => {
            "use strict";
            a.d(e, {
                Z: () => i
            });
            const n = a(1519),
                s = a.n(n)()((function (t) {
                    return t[1]
                }));
            s.push([t.id, ".form-control[data-v-72c868aa]{padding-right:12px}", ""]);
            const i = s
        },
        9308: (t, e, a) => {
            "use strict";
            a.d(e, {
                Z: () => i
            });
            const n = a(1519),
                s = a.n(n)()((function (t) {
                    return t[1]
                }));
            s.push([t.id, ".input-group[data-v-f290b6f6]{padding-bottom:3px}", ""]);
            const i = s
        },
        7873: (t, e, a) => {
            "use strict";
            a.d(e, {
                Z: () => i
            });
            const n = a(1519),
                s = a.n(n)()((function (t) {
                    return t[1]
                }));
            s.push([t.id, "div[data-v-f45258b0]{color:red}", ""]);
            const i = s
        },
        6634: (t, e, a) => {
            "use strict";
            a.d(e, {
                Z: () => i
            });
            const n = a(1519),
                s = a.n(n)()((function (t) {
                    return t[1]
                }));
            s.push([t.id, ".expandable[data-v-915dcab0]{height:30px;padding:5px}.buttons[data-v-915dcab0]{padding:0 5px;white-space:nowrap}.new-btn-div[data-v-915dcab0]{margin-bottom:5px}.panel-body[data-v-915dcab0]{padding:5px 0}", ""]);
            const i = s
        },
        3938: (t, e, a) => {
            "use strict";
            a.d(e, {
                Z: () => i
            });
            const n = a(1519),
                s = a.n(n)()((function (t) {
                    return t[1]
                }));
            s.push([t.id, ".authlevel[data-v-b51be698]{font-size:18px;text-align:left}.fa-minus-circle[data-v-b51be698]{cursor:pointer}.snmp3-add-button[data-v-b51be698]{margin-top:5px}", ""]);
            const i = s
        },
        6682: (t, e, a) => {
            "use strict";
            a.d(e, {
                Z: () => i
            });
            const n = a(1519),
                s = a.n(n)()((function (t) {
                    return t[1]
                }));
            s.push([t.id, ".panel.with-nav-tabs .panel-heading[data-v-2ac3a533]{padding:5px 5px 0}.panel.with-nav-tabs .nav-tabs[data-v-2ac3a533]{border-bottom:none}.panel.with-nav-tabs .nav-justified[data-v-2ac3a533]{margin-bottom:-1px}.with-nav-tabs.panel-default .nav-tabs>li>a[data-v-2ac3a533],.with-nav-tabs.panel-default .nav-tabs>li>a[data-v-2ac3a533]:focus,.with-nav-tabs.panel-default .nav-tabs>li>a[data-v-2ac3a533]:hover{color:#777}.with-nav-tabs.panel-default .nav-tabs>.open>a[data-v-2ac3a533],.with-nav-tabs.panel-default .nav-tabs>.open>a[data-v-2ac3a533]:focus,.with-nav-tabs.panel-default .nav-tabs>.open>a[data-v-2ac3a533]:hover,.with-nav-tabs.panel-default .nav-tabs>li>a[data-v-2ac3a533]:focus,.with-nav-tabs.panel-default .nav-tabs>li>a[data-v-2ac3a533]:hover{background-color:#ddd;border-color:transparent;color:#777}.with-nav-tabs.panel-default .nav-tabs>li.active>a[data-v-2ac3a533],.with-nav-tabs.panel-default .nav-tabs>li.active>a[data-v-2ac3a533]:focus,.with-nav-tabs.panel-default .nav-tabs>li.active>a[data-v-2ac3a533]:hover{background-color:#fff;border-color:#ddd #ddd transparent;color:#555}.with-nav-tabs.panel-default .nav-tabs>li.dropdown .dropdown-menu[data-v-2ac3a533]{background-color:#f5f5f5;border-color:#ddd}.with-nav-tabs.panel-default .nav-tabs>li.dropdown .dropdown-menu>li>a[data-v-2ac3a533]{color:#777}.with-nav-tabs.panel-default .nav-tabs>li.dropdown .dropdown-menu>li>a[data-v-2ac3a533]:focus,.with-nav-tabs.panel-default .nav-tabs>li.dropdown .dropdown-menu>li>a[data-v-2ac3a533]:hover{background-color:#ddd}.with-nav-tabs.panel-default .nav-tabs>li.dropdown .dropdown-menu>.active>a[data-v-2ac3a533],.with-nav-tabs.panel-default .nav-tabs>li.dropdown .dropdown-menu>.active>a[data-v-2ac3a533]:focus,.with-nav-tabs.panel-default .nav-tabs>li.dropdown .dropdown-menu>.active>a[data-v-2ac3a533]:hover{background-color:#555;color:#fff}", ""]);
            const i = s
        },
        1615: (t, e, a) => {
            "use strict";
            a.d(e, {
                Z: () => i
            });
            const n = a(1519),
                s = a.n(n)()((function (t) {
                    return t[1]
                }));
            s.push([t.id, ".enter-active[data-v-54390bb4],.leave-active[data-v-54390bb4]{overflow:hidden;transition:height .2s linear}", ""]);
            const i = s
        },
        4347: () => {},
        3848: () => {},
        4304: (t, e, a) => {
            "use strict";
            a.r(e), a.d(e, {
                default: () => s
            });
            const n = {
                name: "Accordion",
                props: {
                    multiple: {
                        type: Boolean,
                        default: !1
                    }
                },
                methods: {
                    setActive: function(t) {
                        this.$children.forEach((function(e) {
                            e.slug() === t && (e.isActive = !0)
                        }))
                    },
                    activeChanged: function(t) {
                        this.multiple || this.$children.forEach((function(e) {
                            e.slug() !== t && (e.isActive = !1)
                        }))
                    }
                },
                mounted: function() {
                    this.$on("expanded", this.activeChanged)
                }
            };
            const s = (0, a(1900).Z)(n, (function() {
                const t = this,
                    e = t.$createElement;
                return (t._self._c || e)("div", {
                    staticClass: "panel-group",
                    attrs: {
                        role: "tablist"
                    }
                }, [t._t("default")], 2)
            }), [], !1, null, "11dcbcb8", null).exports
        },
        1217: (t, e, a) => {
            "use strict";
            a.r(e), a.d(e, {
                default: () => l
            });
            const n = {
                name: "AccordionItem",
                props: {
                    name: {
                        type: String,
                        required: !0
                    },
                    text: String,
                    active: Boolean,
                    icon: String
                },
                data: function() {
                    return {
                        isActive: this.active
                    }
                },
                mounted: function() {
                    window.location.hash === this.hash() && (this.isActive = !0)
                },
                watch: {
                    active: function(t) {
                        this.isActive = t
                    },
                    isActive: function(t) {
                        this.$parent.$emit(t ? "expanded" : "collapsed", this.slug())
                    }
                },
                methods: {
                    slug: function() {
                        return this.name.toString().toLowerCase().replace(/\s+/g, "-")
                    },
                    hash: function() {
                        return "#" + this.slug()
                    }
                }
            };
            const s = a(3379),
                i = a.n(s),
                o = a(6832),
                r = {
                    insert: "head",
                    singleton: !1
                };
            i()(o.Z, r);
            o.Z.locals;
            const l = (0, a(1900).Z)(n, (function() {
                const t = this,
                    e = t.$createElement,
                    a = t._self._c || e;
                return a("div", {
                    staticClass: "panel panel-default"
                }, [a("div", {
                    staticClass: "panel-heading",
                    attrs: {
                        role: "tab",
                        id: t.slug()
                    }
                }, [a("h4", {
                    staticClass: "panel-title"
                }, [a("a", {
                    staticClass: "accordion-item-trigger",
                    class: {
                        collapsed: !t.isActive
                    },
                    attrs: {
                        role: "button",
                        "data-parent": "#accordion",
                        "data-href": t.hash()
                    },
                    on: {
                        click: function(e) {
                            t.isActive = !t.isActive
                        }
                    }
                }, [a("i", {
                    staticClass: "fa fa-chevron-down accordion-item-trigger-icon"
                }), t._v(" "), t.icon ? a("i", {
                    class: ["fa", "fa-fw", t.icon]
                }) : t._e(), t._v("\n                " + t._s(t.text || t.name) + "\n            ")])])]), t._v(" "), a("transition-collapse-height", [t.isActive ? a("div", {
                    class: ["panel-collapse", "collapse", { in: t.isActive
                    }],
                    attrs: {
                        id: t.slug() + "-content",
                        role: "tabpanel"
                    }
                }, [a("div", {
                    staticClass: "panel-body"
                }, [t._t("default")], 2)]) : t._e()])], 1)
            }), [], !1, null, "16b90b68", null).exports
        },
        9608: (t, e, a) => {
            "use strict";
            a.r(e), a.d(e, {
                default: () => s
            });
            const n = {
                name: "BaseSetting",
                props: {
                    name: {
                        type: String,
                        required: !0
                    },
                    value: {
                        required: !0
                    },
                    disabled: Boolean,
                    required: Boolean,
                    pattern: String,
                    "update-status": String,
                    options: {}
                }
            };
            const s = (0, a(1900).Z)(n, undefined, undefined, !1, null, null, null).exports
        },
        6784: (t, e, a) => {
            "use strict";
            a.r(e), a.d(e, {
                default: () => s
            });
            const n = {
                mounted: function() {
                    console.log("Component mounted.")
                }
            };
            const s = (0, a(1900).Z)(n, (function() {
                const t = this,
                    e = t.$createElement;
                t._self._c;
                return t._m(0)
            }), [function() {
                const t = this,
                    e = t.$createElement,
                    a = t._self._c || e;
                return a("div", {
                    staticClass: "container"
                }, [a("div", {
                    staticClass: "row justify-content-center"
                }, [a("div", {
                    staticClass: "col-md-8"
                }, [a("div", {
                    staticClass: "card"
                }, [a("div", {
                    staticClass: "card-header"
                }, [t._v("Example Component")]), t._v(" "), a("div", {
                    staticClass: "card-body"
                }, [t._v("\n                    I'm an example component.\n                ")])])])])])
            }], !1, null, null, null).exports
        },
        3460: (t, e, a) => {
            "use strict";
            a.r(e), a.d(e, {
                default: () => u
            });
            const n = {
                    name: "LibrenmsSetting",
                    props: {
                        setting: {
                            type: Object,
                            required: !0
                        },
                        prefix: {
                            type: String,
                            default: "settings"
                        },
                        id: {
                            required: !1
                        }
                    },
                    data: function() {
                        return {
                            value: this.setting.value,
                            updateStatus: "none",
                            feedback: ""
                        }
                    },
                    methods: {
                        persistValue: function(t) {
                            const e = this;
                            this.updateStatus = "pending", axios.put(route(this.prefix + ".update", this.getRouteParams()), {
                                value: t
                            }).then((function(t) {
                                e.value = t.data.value, e.$emit("setting-updated", {
                                    name: e.setting.name,
                                    value: e.value
                                }), e.updateStatus = "success", e.feedback = "has-success", setTimeout((function() {
                                    return e.feedback = ""
                                }), 3e3)
                            })).catch((function(t) {
                                e.feedback = "has-error", e.updateStatus = "error", toastr.error(t.response.data.message);
                                ["text", "email", "password"].includes(e.setting.type) || (e.value = t.response.data.value, e.$emit("setting-updated", {
                                    name: e.setting.name,
                                    value: e.value
                                }), setTimeout((function() {
                                    return e.feedback = ""
                                }), 3e3))
                            }))
                        },
                        debouncePersistValue: _.debounce((function(t) {
                            this.persistValue(t)
                        }), 500),
                        changeValue: function(t) {
                            ["select", "boolean", "multiple"].includes(this.setting.type) ? this.persistValue(t) : this.debouncePersistValue(t), this.value = t
                        },
                        getUnits: function() {
                            const t = this.prefix + ".units." + this.setting.units;
                            return this.$te(t) ? this.$t(t) : this.setting.units
                        },
                        getDescription: function() {
                            const t = this.prefix + ".settings." + this.setting.name + ".description";
                            return this.$te(t) || this.$te(t, this.$i18n.fallbackLocale) ? this.$t(t) : this.setting.name
                        },
                        getHelp: function() {
                            let t = this.$t(this.prefix + ".settings." + this.setting.name + ".help");
                            return this.setting.overridden && (t += "</p><p>" + this.$t(this.prefix + ".readonly")), t
                        },
                        hasHelp: function() {
                            const t = this.prefix + ".settings." + this.setting.name + ".help";
                            return this.$te(t) || this.$te(t, this.$i18n.fallbackLocale)
                        },
                        resetToDefault: function() {
                            const t = this;
                            axios.delete(route(this.prefix + ".destroy", this.getRouteParams())).then((function(e) {
                                t.value = e.data.value, t.feedback = "has-success", setTimeout((function() {
                                    return t.feedback = ""
                                }), 3e3)
                            })).catch((function(e) {
                                t.feedback = "has-error", setTimeout((function() {
                                    return t.feedback = ""
                                }), 3e3), toastr.error(e.response.data.message)
                            }))
                        },
                        resetToInitial: function() {
                            this.changeValue(this.setting.value)
                        },
                        showResetToDefault: function() {
                            return !this.setting.overridden && !_.isEqual(this.value, this.setting.default)
                        },
                        showUndo: function() {
                            return !_.isEqual(this.setting.value, this.value)
                        },
                        getRouteParams: function() {
                            const t = [this.setting.name];
                            return this.id && t.unshift(this.id), t
                        },
                        getComponent: function() {
                            const t = "Setting" + this.setting.type.toString().replace(/(-[a-z]|^[a-z])/g, (function (t) {
                                return t.toUpperCase().replace("-", "")
                            }));
                            return void 0 !== Vue.options.components[t] ? t : "SettingNull"
                        }
                    }
                },
                s = n;
            const i = a(3379),
                o = a.n(i),
                r = a(7612),
                l = {
                    insert: "head",
                    singleton: !1
                };
            o()(r.Z, l);
            r.Z.locals;
            const u = (0, a(1900).Z)(s, (function() {
                const t = this,
                    e = t.$createElement,
                    a = t._self._c || e;
                return a("div", {
                    class: ["form-group", "has-feedback", t.setting.class, t.feedback]
                }, [a("label", {
                    directives: [{
                        name: "tooltip",
                        rawName: "v-tooltip",
                        value: {
                            content: t.setting.name
                        },
                        expression: "{ content: setting.name }"
                    }],
                    staticClass: "col-sm-5 control-label",
                    attrs: {
                        for: t.setting.name
                    }
                }, [t._v("\n        " + t._s(t.getDescription()) + "\n        "), t.setting.units ? a("span", [t._v("(" + t._s(t.getUnits()) + ")")]) : t._e()]), t._v(" "), a("div", {
                    directives: [{
                        name: "tooltip",
                        rawName: "v-tooltip",
                        value: {
                            content: !!t.setting.disabled && t.$t(this.prefix + ".readonly")
                        },
                        expression: "{ content: setting.disabled ? $t(this.prefix + '.readonly') : false }"
                    }],
                    staticClass: "col-sm-5"
                }, [a(t.getComponent(), {
                    tag: "component",
                    attrs: {
                        value: t.value,
                        name: t.setting.name,
                        pattern: t.setting.pattern,
                        disabled: t.setting.overridden,
                        required: t.setting.required,
                        options: t.setting.options,
                        "update-status": t.updateStatus
                    },
                    on: {
                        input: function(e) {
                            return t.changeValue(e)
                        },
                        change: function(e) {
                            return t.changeValue(e)
                        }
                    }
                }), t._v(" "), a("span", {
                    staticClass: "form-control-feedback"
                })], 1), t._v(" "), a("div", {
                    staticClass: "col-sm-2"
                }, [a("button", {
                    directives: [{
                        name: "tooltip",
                        rawName: "v-tooltip",
                        value: {
                            content: t.$t("Reset to default")
                        },
                        expression: "{ content: $t('Reset to default') }"
                    }],
                    staticClass: "btn btn-default",
                    class: {
                        "disable-events": !t.showResetToDefault()
                    },
                    style: {
                        opacity: t.showResetToDefault() ? 1 : 0
                    },
                    attrs: {
                        type: "button"
                    },
                    on: {
                        click: t.resetToDefault
                    }
                }, [a("i", {
                    staticClass: "fa fa-refresh"
                })]), t._v(" "), a("button", {
                    directives: [{
                        name: "tooltip",
                        rawName: "v-tooltip",
                        value: {
                            content: t.$t("Undo")
                        },
                        expression: "{ content: $t('Undo') }"
                    }],
                    staticClass: "btn btn-primary",
                    class: {
                        "disable-events": !t.showUndo()
                    },
                    style: {
                        opacity: t.showUndo() ? 1 : 0
                    },
                    attrs: {
                        type: "button"
                    },
                    on: {
                        click: t.resetToInitial
                    }
                }, [a("i", {
                    staticClass: "fa fa-undo"
                })]), t._v(" "), t.hasHelp() ? a("div", {
                    directives: [{
                        name: "tooltip",
                        rawName: "v-tooltip",
                        value: {
                            content: t.getHelp(),
                            trigger: "hover click"
                        },
                        expression: "{content: getHelp(), trigger: 'hover click'}"
                    }],
                    staticClass: "fa fa-fw fa-lg fa-question-circle"
                }) : t._e()])])
            }), [], !1, null, "d23a875a", null).exports
        },
        2872: (t, e, a) => {
            "use strict";
            a.r(e), a.d(e, {
                default: () => c
            });

            function n(t, e) {
                return function(t) {
                    if (Array.isArray(t)) return t
                }(t) || function(t, e) {
                    let a = null == t ? null : "undefined" != typeof Symbol && t[Symbol.iterator] || t["@@iterator"];
                    if (null == a) return;
                    let n, s;
                    const i = [];
                    let o = !0,
                        r = !1;
                    try {
                        for (a = a.call(t); !(o = (n = a.next()).done) && (i.push(n.value), !e || i.length !== e); o = !0);
                    } catch (t) {
                        r = !0, s = t
                    } finally {
                        try {
                            o || null == a.return || a.return()
                        } finally {
                            if (r) throw s
                        }
                    }
                    return i
                }(t, e) || function(t, e) {
                    if (!t) return;
                    if ("string" == typeof t) return s(t, e);
                    let a = Object.prototype.toString.call(t).slice(8, -1);
                    "Object" === a && t.constructor && (a = t.constructor.name);
                    if ("Map" === a || "Set" === a) return Array.from(t);
                    if ("Arguments" === a || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(a)) return s(t, e)
                }(t, e) || function() {
                    throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")
                }()
            }

            function s(t, e) {
                (null == e || e > t.length) && (e = t.length);
                for (var a = 0, n = new Array(e); a < e; a++) n[a] = t[a];
                return n
            }
            const i = {
                name: "LibrenmsSettings",
                props: {
                    prefix: String,
                    initialTab: {
                        type: String,
                        default: "alerting"
                    },
                    initialSection: String,
                    tabs: {
                        type: Array
                    }
                },
                data: function() {
                    return {
                        tab: this.initialTab,
                        section: this.initialSection,
                        search_phrase: "",
                        settings: {}
                    }
                },
                methods: {
                    tabChanged: function(t) {
                        this.tab !== t && (this.tab = t, this.section = null, this.updateUrl())
                    },
                    sectionExpanded: function(t) {
                        this.section = t, this.updateUrl()
                    },
                    sectionCollapsed: function(t) {
                        this.section === t && (this.section = null, this.updateUrl())
                    },
                    updateUrl: function() {
                        let t = this.tab;
                        this.section && (t += "/" + this.section), window.history.pushState(t, "", this.prefix + "/" + t)
                    },
                    handleBack: function(t) {
                        const e = n(t.state.split("/"), 2);
                        this.tab = e[0], this.section = e[1]
                    },
                    updateSetting: function(t, e) {
                        this.$set(this.settings[t], "value", e)
                    },
                    settingShown: function(t) {
                        const e = this,
                            a = this.settings[t];
                        return null === a.when || (a.when.hasOwnProperty("and") ? a.when.and.reduce((function(t, a) {
                            return e.checkLogic(a) && t
                        }), !0) : a.when.hasOwnProperty("or") ? a.when.or.reduce((function(t, a) {
                            return e.checkLogic(a) || t
                        }), !1) : this.checkLogic(a.when))
                    },
                    translatedCompare: function(t, e, a, n) {
                        return this.$t(t + e + n).localeCompare(this.$t(t + a + n))
                    },
                    checkLogic: function(t) {
                        switch (t.operator) {
                            case "equals":
                                return this.settings[t.setting].value === t.value;
                            case "in":
                                return t.value.includes(this.settings[t.setting].value);
                            default:
                                return !0
                        }
                    }
                },
                mounted: function() {
                    const t = this;
                    window.onpopstate = this.handleBack, axios.get(route("settings.list")).then((function(e) {
                        return t.settings = e.data
                    }))
                },
                computed: {
                    groups: function() {
                        const t = this;
                        if (_.isEmpty(this.settings)) {
                            var e = {};
                            return this.tabs.sort((function(e, a) {
                                return t.translatedCompare("settings.groups.", e, a)
                            })).forEach((function(t) {
                                e[t] = []
                            })), e
                        }
                        for (var a = {}, n = 0, s = Object.keys(this.settings); n < s.length; n++) {
                            const i = s[n],
                                o = this.settings[i];
                            o.name.includes(this.search_phrase) && (o.group && (o.group in a || (a[o.group] = {}), o.section && (o.section in a[o.group] || (a[o.group][o.section] = []), a[o.group][o.section].push(o))))
                        }
                        const r = {};
                        return Object.keys(a).sort((function(e, a) {
                            return t.translatedCompare("settings.groups.", e, a)
                        })).forEach((function(e) {
                            r[e] = {}, Object.keys(a[e]).sort((function(a, n) {
                                return t.translatedCompare("settings.sections." + e + ".", a, n, ".name")
                            })).forEach((function(t) {
                                r[e][t] = _.sortBy(a[e][t], "order").map((function(t) {
                                    return t.name
                                }))
                            }))
                        })), r
                    }
                }
            };
            var o = a(3379),
                r = a.n(o),
                l = a(1973),
                u = {
                    insert: "head",
                    singleton: !1
                };
            r()(l.Z, u);
            l.Z.locals;
            const c = (0, a(1900).Z)(i, (function() {
                const t = this,
                    e = t.$createElement,
                    a = t._self._c || e;
                return a("tabs", {
                    attrs: {
                        selected: this.tab
                    },
                    on: {
                        "tab-selected": t.tabChanged
                    },
                    scopedSlots: t._u([{
                        key: "header",
                        fn: function() {
                            return [a("form", {
                                staticClass: "form-inline",
                                on: {
                                    submit: function(t) {
                                        t.preventDefault()
                                    }
                                }
                            }, [a("div", {
                                staticClass: "input-group"
                            }, [a("input", {
                                directives: [{
                                    name: "model",
                                    rawName: "v-model.trim",
                                    value: t.search_phrase,
                                    expression: "search_phrase",
                                    modifiers: {
                                        trim: !0
                                    }
                                }],
                                staticClass: "form-control",
                                attrs: {
                                    id: "settings-search",
                                    type: "search",
                                    placeholder: t.$t("Filter Settings")
                                },
                                domProps: {
                                    value: t.search_phrase
                                },
                                on: {
                                    input: function(e) {
                                        e.target.composing || (t.search_phrase = e.target.value.trim())
                                    },
                                    blur: function(e) {
                                        return t.$forceUpdate()
                                    }
                                }
                            })])])]
                        },
                        proxy: !0
                    }])
                }, [t._v(" "), a("tab", {
                    attrs: {
                        name: "global",
                        selected: "global" === t.tab,
                        text: t.$t("settings.groups.global")
                    }
                }, [a("ul", {
                    staticClass: "settings-list"
                }, t._l(t.settings, (function(e) {
                    return a("li", [a("strong", [t._v(t._s(e.name))]), t._v(" "), a("code", [t._v(t._s(e.value))])])
                })), 0)]), t._v(" "), t._l(t.groups, (function(e, n) {
                    return a("tab", {
                        key: n,
                        attrs: {
                            name: n,
                            selected: n === t.tab,
                            text: t.$t("settings.groups." + n)
                        }
                    }, [a("accordion", {
                        on: {
                            expanded: t.sectionExpanded,
                            collapsed: t.sectionCollapsed
                        }
                    }, t._l(t.groups[n], (function(e, s) {
                        return a("accordion-item", {
                            key: s,
                            attrs: {
                                name: s,
                                text: t.$t("settings.sections." + n + "." + s + ".name"),
                                active: s === t.section
                            }
                        }, [t.$te("settings.sections." + n + "." + s + ".description") ? [a("h5", [t._v(t._s(t.$t("settings.sections." + n + "." + s + ".description")))]), t._v(" "), a("hr")] : t._e(), t._v(" "), a("form", {
                            staticClass: "form-horizontal",
                            on: {
                                submit: function(t) {
                                    t.preventDefault()
                                }
                            }
                        }, t._l(e, (function(e) {
                            return a("librenms-setting", {
                                directives: [{
                                    name: "show",
                                    rawName: "v-show",
                                    value: t.settingShown(e),
                                    expression: "settingShown(setting)"
                                }],
                                key: e,
                                attrs: {
                                    setting: t.settings[e]
                                },
                                on: {
                                    "setting-updated": function(e) {
                                        return t.updateSetting(e.name, e.value)
                                    }
                                }
                            })
                        })), 1)], 2)
                    })), 1)], 1)
                }))], 2)
            }), [], !1, null, "c1efd320", null).exports
        },
        707: (t, e, a) => {
            "use strict";
            a.r(e), a.d(e, {
                default: () => c
            });
            const n = {
                name: "PollerSettings",
                props: {
                    pollers: Object,
                    settings: Object
                },
                data: function() {
                    return {
                        advanced: !1
                    }
                }
            };
            const s = a(3379),
                i = a.n(s),
                o = a(3594),
                r = {
                    insert: "head",
                    singleton: !1
                };
            i()(o.Z, r);
            o.Z.locals;
            const l = a(3485),
                u = {
                    insert: "head",
                    singleton: !1
                };
            i()(l.Z, u);
            l.Z.locals;
            const c = (0, a(1900).Z)(n, (function() {
                const t = this,
                    e = t.$createElement,
                    a = t._self._c || e;
                return a("div", {
                    staticClass: "panel panel-default"
                }, [a("div", {
                    staticClass: "panel-heading"
                }, [a("h3", {
                    staticClass: "panel-title"
                }, [t._v("\n            " + t._s(t.$t("Poller Settings")) + "\n            "), a("span", {
                    staticClass: "pull-right"
                }, [t._v("Advanced "), a("toggle-button", {
                    model: {
                        value: t.advanced,
                        callback: function(e) {
                            t.advanced = e
                        },
                        expression: "advanced"
                    }
                })], 1)])]), t._v(" "), a("div", {
                    staticClass: "panel-body"
                }, [a("vue-tabs", {
                    attrs: {
                        direction: "vertical",
                        type: "pills"
                    }
                }, t._l(t.pollers, (function(e, n) {
                    return a("v-tab", {
                        key: n,
                        attrs: {
                            title: e.poller_name
                        }
                    }, t._l(t.settings[n], (function(n) {
                        return !n.advanced || t.advanced ? a("div", {
                            key: n.name,
                            staticClass: "setting-container clearfix"
                        }, [a("librenms-setting", {
                            attrs: {
                                prefix: "poller.settings",
                                setting: n,
                                id: e.id
                            }
                        })], 1) : t._e()
                    })), 0)
                })), 1)], 1)])
            }), [], !1, null, "5ab9fce1", null).exports
        },
        3334: (t, e, a) => {
            "use strict";
            a.r(e), a.d(e, {
                default: () => d
            });
            const n = a(9608),
                s = a(9980),
                i = a.n(s);
            const o = {
                name: "SettingArray",
                mixins: [n.default],
                components: {
                    draggable: i()
                },
                data: function() {
                    let t;
                    return {
                        localList: null !== (t = this.value) && void 0 !== t ? t : [],
                        newItem: ""
                    }
                },
                methods: {
                    addItem: function() {
                        this.disabled || (this.localList.push(this.newItem), this.$emit("input", this.localList), this.newItem = "")
                    },
                    removeItem: function(t) {
                        this.disabled || (this.localList.splice(t, 1), this.$emit("input", this.localList))
                    },
                    updateItem: function(t, e) {
                        this.disabled || this.localList[t] === e || (this.localList[t] = e, this.$emit("input", this.localList))
                    },
                    dragged: function() {
                        this.disabled || this.$emit("input", this.localList)
                    }
                },
                watch: {
                    value: function(t) {
                        this.localList = t
                    }
                }
            };
            const r = a(3379),
                l = a.n(r),
                u = a(5319),
                c = {
                    insert: "head",
                    singleton: !1
                };
            l()(u.Z, c);
            u.Z.locals;
            const d = (0, a(1900).Z)(o, (function() {
                const t = this,
                    e = t.$createElement,
                    a = t._self._c || e;
                return a("div", {
                    directives: [{
                        name: "tooltip",
                        rawName: "v-tooltip",
                        value: !!t.disabled && t.$t("settings.readonly"),
                        expression: "disabled ? $t('settings.readonly') : false"
                    }]
                }, [a("draggable", {
                    attrs: {
                        disabled: t.disabled
                    },
                    on: {
                        end: function(e) {
                            return t.dragged()
                        }
                    },
                    model: {
                        value: t.localList,
                        callback: function(e) {
                            t.localList = e
                        },
                        expression: "localList"
                    }
                }, t._l(t.localList, (function(e, n) {
                    return a("div", {
                        staticClass: "input-group"
                    }, [a("span", {
                        class: ["input-group-addon", t.disabled ? "disabled" : ""]
                    }, [t._v(t._s(n + 1) + ".")]), t._v(" "), a("input", {
                        staticClass: "form-control",
                        attrs: {
                            type: "text",
                            readonly: t.disabled
                        },
                        domProps: {
                            value: e
                        },
                        on: {
                            blur: function(e) {
                                return t.updateItem(n, e.target.value)
                            },
                            keyup: function(e) {
                                return !e.type.indexOf("key") && t._k(e.keyCode, "enter", 13, e.key, "Enter") ? null : t.updateItem(n, e.target.value)
                            }
                        }
                    }), t._v(" "), a("span", {
                        staticClass: "input-group-btn"
                    }, [t.disabled ? t._e() : a("button", {
                        staticClass: "btn btn-danger",
                        attrs: {
                            type: "button"
                        },
                        on: {
                            click: function(e) {
                                return t.removeItem(n)
                            }
                        }
                    }, [a("i", {
                        staticClass: "fa fa-minus-circle"
                    })])])])
                })), 0), t._v(" "), t.disabled ? t._e() : a("div", [a("div", {
                    staticClass: "input-group"
                }, [a("input", {
                    directives: [{
                        name: "model",
                        rawName: "v-model",
                        value: t.newItem,
                        expression: "newItem"
                    }],
                    staticClass: "form-control",
                    attrs: {
                        type: "text"
                    },
                    domProps: {
                        value: t.newItem
                    },
                    on: {
                        keyup: function(e) {
                            return !e.type.indexOf("key") && t._k(e.keyCode, "enter", 13, e.key, "Enter") ? null : t.addItem.apply(null, arguments)
                        },
                        input: function(e) {
                            e.target.composing || (t.newItem = e.target.value)
                        }
                    }
                }), t._v(" "), a("span", {
                    staticClass: "input-group-btn"
                }, [a("button", {
                    staticClass: "btn btn-primary",
                    attrs: {
                        type: "button"
                    },
                    on: {
                        click: t.addItem
                    }
                }, [a("i", {
                    staticClass: "fa fa-plus-circle"
                })])])])])], 1)
            }), [], !1, null, "588cd6c1", null).exports
        },
        2421: (t, e, a) => {
            "use strict";
            a.r(e), a.d(e, {
                default: () => l
            });
            const n = {
                name: "SettingArraySubKeyed",
                mixins: [a(9608).default],
                data: function() {
                    let t;
                    return {
                        localList: null !== (t = this.value) && void 0 !== t ? t : {},
                        newSubItemKey: {},
                        newSubItemValue: {},
                        newSubArray: ""
                    }
                },
                methods: {
                    addSubItem: function(t) {
                        if (!this.disabled) {
                            const e = {};
                            e[this.newSubItemKey[t]] = this.newSubItemValue[t], 0 === Object.keys(this.localList[t]).length && (this.localList[t] = {}), Object.assign(this.localList[t], e), this.$emit("input", this.localList), this.newSubItemValue[t] = "", this.newSubItemKey[t] = ""
                        }
                    },
                    removeSubItem: function(t, e) {
                        this.disabled || (delete this.localList[t][e], 0 === Object.keys(this.localList[t]).length && delete this.localList[t], this.$emit("input", this.localList))
                    },
                    updateSubItem: function(t, e, a) {
                        this.disabled || this.localList[t][e] === a || (this.localList[t][e] = a, this.$emit("input", this.localList))
                    },
                    addSubArray: function() {
                        this.disabled || (this.localList[this.newSubArray] = {}, this.$emit("input", this.localList), this.newSubArray = "")
                    }
                },
                watch: {
                    value: function(t) {
                        this.localList = t
                    }
                }
            };
            const s = a(3379),
                i = a.n(s),
                o = a(514),
                r = {
                    insert: "head",
                    singleton: !1
                };
            i()(o.Z, r);
            o.Z.locals;
            const l = (0, a(1900).Z)(n, (function() {
                const t = this,
                    e = t.$createElement,
                    a = t._self._c || e;
                return a("div", {
                    directives: [{
                        name: "tooltip",
                        rawName: "v-tooltip",
                        value: !!t.disabled && t.$t("settings.readonly"),
                        expression: "disabled ? $t('settings.readonly') : false"
                    }]
                }, [t._l(t.localList, (function(e, n) {
                    return a("div", [a("b", [t._v(t._s(n))]), t._v(" "), t._l(e, (function(e, s) {
                        return a("div", {
                            staticClass: "input-group"
                        }, [a("span", {
                            class: ["input-group-addon", t.disabled ? "disabled" : ""]
                        }, [t._v(t._s(s))]), t._v(" "), a("input", {
                            staticClass: "form-control",
                            attrs: {
                                type: "text",
                                readonly: t.disabled
                            },
                            domProps: {
                                value: e
                            },
                            on: {
                                blur: function(e) {
                                    return t.updateSubItem(n, s, e.target.value)
                                },
                                keyup: function(e) {
                                    return !e.type.indexOf("key") && t._k(e.keyCode, "enter", 13, e.key, "Enter") ? null : t.updateSubItem(n, s, e.target.value)
                                }
                            }
                        }), t._v(" "), a("span", {
                            staticClass: "input-group-btn"
                        }, [t.disabled ? t._e() : a("button", {
                            staticClass: "btn btn-danger",
                            attrs: {
                                type: "button"
                            },
                            on: {
                                click: function(e) {
                                    return t.removeSubItem(n, s)
                                }
                            }
                        }, [a("i", {
                            staticClass: "fa fa-minus-circle"
                        })])])])
                    })), t._v(" "), t.disabled ? t._e() : a("div", [a("div", {
                        staticClass: "row"
                    }, [a("div", {
                        staticClass: "col-lg-4"
                    }, [a("div", {
                        staticClass: "input-group"
                    }, [a("input", {
                        directives: [{
                            name: "model",
                            rawName: "v-model",
                            value: t.newSubItemKey[n],
                            expression: "newSubItemKey[index]"
                        }],
                        staticClass: "form-control",
                        attrs: {
                            type: "text",
                            placeholder: "Key"
                        },
                        domProps: {
                            value: t.newSubItemKey[n]
                        },
                        on: {
                            input: function(e) {
                                e.target.composing || t.$set(t.newSubItemKey, n, e.target.value)
                            }
                        }
                    })])]), t._v(" "), a("div", {
                        staticClass: "col-lg-8"
                    }, [a("div", {
                        staticClass: "input-group"
                    }, [a("input", {
                        directives: [{
                            name: "model",
                            rawName: "v-model",
                            value: t.newSubItemValue[n],
                            expression: "newSubItemValue[index]"
                        }],
                        staticClass: "form-control",
                        attrs: {
                            type: "text",
                            placeholder: "Value"
                        },
                        domProps: {
                            value: t.newSubItemValue[n]
                        },
                        on: {
                            keyup: function(e) {
                                return !e.type.indexOf("key") && t._k(e.keyCode, "enter", 13, e.key, "Enter") ? null : t.addSubItem(n)
                            },
                            input: function(e) {
                                e.target.composing || t.$set(t.newSubItemValue, n, e.target.value)
                            }
                        }
                    }), t._v(" "), a("span", {
                        staticClass: "input-group-btn"
                    }, [a("button", {
                        staticClass: "btn btn-primary",
                        attrs: {
                            type: "button"
                        },
                        on: {
                            click: function(e) {
                                return t.addSubItem(n)
                            }
                        }
                    }, [a("i", {
                        staticClass: "fa fa-plus-circle"
                    })])])])])])]), t._v(" "), a("hr")], 2)
                })), t._v(" "), t.disabled ? t._e() : a("div", [a("div", {
                    staticClass: "input-group"
                }, [a("input", {
                    directives: [{
                        name: "model",
                        rawName: "v-model",
                        value: t.newSubArray,
                        expression: "newSubArray"
                    }],
                    staticClass: "form-control",
                    attrs: {
                        type: "text"
                    },
                    domProps: {
                        value: t.newSubArray
                    },
                    on: {
                        keyup: function(e) {
                            return !e.type.indexOf("key") && t._k(e.keyCode, "enter", 13, e.key, "Enter") ? null : t.addSubArray.apply(null, arguments)
                        },
                        input: function(e) {
                            e.target.composing || (t.newSubArray = e.target.value)
                        }
                    }
                }), t._v(" "), a("span", {
                    staticClass: "input-group-btn"
                }, [a("button", {
                    staticClass: "btn btn-primary",
                    attrs: {
                        type: "button"
                    },
                    on: {
                        click: t.addSubArray
                    }
                }, [a("i", {
                    staticClass: "fa fa-plus-circle"
                })])])])])], 2)
            }), [], !1, null, "dcc80002", null).exports
        },
        3554: (t, e, a) => {
            "use strict";
            a.r(e), a.d(e, {
                default: () => s
            });
            const n = {
                name: "SettingBoolean",
                mixins: [a(9608).default]
            };
            const s = (0, a(1900).Z)(n, (function() {
                const t = this,
                    e = t.$createElement;
                return (t._self._c || e)("toggle-button", {
                    attrs: {
                        name: t.name,
                        value: t.value,
                        sync: !0,
                        required: t.required,
                        disabled: t.disabled
                    },
                    on: {
                        change: function(e) {
                            return t.$emit("change", e.value)
                        }
                    }
                })
            }), [], !1, null, "ab7ed6ee", null).exports
        },
        573: (t, e, a) => {
            "use strict";
            a.r(e), a.d(e, {
                default: () => s
            });
            const n = {
                name: "SettingDirectory",
                mixins: [a(9608).default]
            };
            const s = (0, a(1900).Z)(n, (function() {
                const t = this,
                    e = t.$createElement;
                return (t._self._c || e)("input", {
                    staticClass: "form-control",
                    attrs: {
                        type: "text",
                        name: t.name,
                        pattern: t.pattern,
                        required: t.required,
                        disabled: t.disabled
                    },
                    domProps: {
                        value: t.value
                    },
                    on: {
                        input: function(e) {
                            return t.$emit("input", e.target.value)
                        }
                    }
                })
            }), [], !1, null, "a44ee658", null).exports
        },
        543: (t, e, a) => {
            "use strict";
            a.r(e), a.d(e, {
                default: () => s
            });
            const n = {
                name: "SettingEmail",
                mixins: [a(9608).default]
            };
            const s = (0, a(1900).Z)(n, (function() {
                const t = this,
                    e = t.$createElement;
                return (t._self._c || e)("input", {
                    staticClass: "form-control",
                    attrs: {
                        type: "email",
                        name: t.name,
                        pattern: t.pattern,
                        required: t.required,
                        disabled: t.disabled
                    },
                    domProps: {
                        value: t.value
                    },
                    on: {
                        input: function(e) {
                            return t.$emit("input", e.target.value)
                        }
                    }
                })
            }), [], !1, null, "62ce370c", null).exports
        },
        9844: (t, e, a) => {
            "use strict";
            a.r(e), a.d(e, {
                default: () => s
            });
            const n = {
                name: "SettingExecutable",
                mixins: [a(9608).default]
            };
            const s = (0, a(1900).Z)(n, (function() {
                const t = this,
                    e = t.$createElement;
                return (t._self._c || e)("input", {
                    staticClass: "form-control",
                    attrs: {
                        type: "text",
                        name: t.name,
                        pattern: t.pattern,
                        required: t.required,
                        disabled: t.disabled
                    },
                    domProps: {
                        value: t.value
                    },
                    on: {
                        input: function(e) {
                            return t.$emit("input", e.target.value)
                        }
                    }
                })
            }), [], !1, null, "a93fcd56", null).exports
        },
        4517: (t, e, a) => {
            "use strict";
            a.r(e), a.d(e, {
                default: () => l
            });
            const n = {
                name: "SettingFloat",
                mixins: [a(9608).default],
                methods: {
                    parseNumber: function(t) {
                        const e = parseFloat(t);
                        return isNaN(e) ? t : e
                    }
                }
            };
            const s = a(3379),
                i = a.n(s),
                o = a(3278),
                r = {
                    insert: "head",
                    singleton: !1
                };
            i()(o.Z, r);
            o.Z.locals;
            const l = (0, a(1900).Z)(n, (function() {
                const t = this,
                    e = t.$createElement;
                return (t._self._c || e)("input", {
                    staticClass: "form-control",
                    attrs: {
                        type: "number",
                        name: t.name,
                        required: t.required,
                        disabled: t.disabled
                    },
                    domProps: {
                        value: t.value
                    },
                    on: {
                        input: function(e) {
                            t.$emit("input", t.parseNumber(e.target.value))
                        }
                    }
                })
            }), [], !1, null, "66aaec8d", null).exports
        },
        1707: (t, e, a) => {
            "use strict";
            a.r(e), a.d(e, {
                default: () => l
            });
            const n = {
                name: "SettingInteger",
                mixins: [a(9608).default],
                methods: {
                    parseNumber: function(t) {
                        const e = parseFloat(t);
                        return isNaN(e) ? t : e
                    }
                }
            };
            const s = a(3379),
                i = a.n(s),
                o = a(5544),
                r = {
                    insert: "head",
                    singleton: !1
                };
            i()(o.Z, r);
            o.Z.locals;
            const l = (0, a(1900).Z)(n, (function() {
                const t = this,
                    e = t.$createElement;
                return (t._self._c || e)("input", {
                    staticClass: "form-control",
                    attrs: {
                        type: "number",
                        name: t.name,
                        required: t.required,
                        disabled: t.disabled
                    },
                    domProps: {
                        value: t.value
                    },
                    on: {
                        input: function(e) {
                            t.$emit("input", t.parseNumber(e.target.value))
                        }
                    }
                })
            }), [], !1, null, "72c868aa", null).exports
        },
        7561: (t, e, a) => {
            "use strict";
            a.r(e), a.d(e, {
                default: () => l
            });
            const n = {
                name: "SettingLdapGroups",
                mixins: [a(9608).default],
                data: function() {
                    return {
                        localList: Array.isArray(this.value) ? {} : this.value,
                        newItem: "",
                        newItemLevel: 1,
                        lock: !1
                    }
                },
                methods: {
                    addItem: function() {
                        this.$set(this.localList, this.newItem, {
                            level: this.newItemLevel
                        }), this.newItem = "", this.newItemLevel = 1
                    },
                    removeItem: function(t) {
                        this.$delete(this.localList, t)
                    },
                    updateItem: function(t, e) {
                        const a = this;
                        this.localList = Object.keys(this.localList).reduce((function(n, s) {
                            return n[s === t ? e : s] = a.localList[s], n
                        }), {})
                    },
                    updateLevel: function(t, e) {
                        this.$set(this.localList, t, {
                            level: e
                        })
                    }
                },
                watch: {
                    localList: function() {
                        this.lock ? this.lock = !1 : this.$emit("input", this.localList)
                    },
                    value: function() {
                        this.lock = !0, this.localList = Array.isArray(this.value) ? {} : this.value
                    }
                }
            };
            var s = a(3379),
                i = a.n(s),
                o = a(9308),
                r = {
                    insert: "head",
                    singleton: !1
                };
            i()(o.Z, r);
            o.Z.locals;
            const l = (0, a(1900).Z)(n, (function() {
                const t = this,
                    e = t.$createElement,
                    a = t._self._c || e;
                return a("div", {
                    directives: [{
                        name: "tooltip",
                        rawName: "v-tooltip",
                        value: !!t.disabled && t.$t("settings.readonly"),
                        expression: "disabled ? $t('settings.readonly') : false"
                    }],
                    staticClass: "form-inline"
                }, [t._l(t.localList, (function(e, n) {
                    return a("div", {
                        staticClass: "input-group"
                    }, [a("input", {
                        staticClass: "form-control",
                        attrs: {
                            type: "text",
                            readonly: t.disabled
                        },
                        domProps: {
                            value: n
                        },
                        on: {
                            blur: function(e) {
                                return t.updateItem(n, e.target.value)
                            },
                            keyup: function(e) {
                                return !e.type.indexOf("key") && t._k(e.keyCode, "enter", 13, e.key, "Enter") ? null : t.updateItem(n, e.target.value)
                            }
                        }
                    }), t._v(" "), a("span", {
                        staticClass: "input-group-btn",
                        staticStyle: {
                            width: "0"
                        }
                    }), t._v(" "), a("select", {
                        staticClass: "form-control",
                        on: {
                            change: function(e) {
                                return t.updateLevel(n, e.target.value)
                            }
                        }
                    }, [a("option", {
                        attrs: {
                            value: "1"
                        },
                        domProps: {
                            selected: 1 === e.level
                        }
                    }, [t._v(t._s(t.$t("Normal")))]), t._v(" "), a("option", {
                        attrs: {
                            value: "4"
                        },
                        domProps: {
                            selected: 4 === e.level
                        }
                    }, [t._v(t._s(t.$t("Limited Write")))]), t._v(" "), a("option", {
                        attrs: {
                            value: "5"
                        },
                        domProps: {
                            selected: 5 === e.level
                        }
                    }, [t._v(t._s(t.$t("Global Read")))]), t._v(" "), a("option", {
                        attrs: {
                            value: "10"
                        },
                        domProps: {
                            selected: 10 === e.level
                        }
                    }, [t._v(t._s(t.$t("Admin")))])]), t._v(" "), a("span", {
                        staticClass: "input-group-btn"
                    }, [t.disabled ? t._e() : a("button", {
                        staticClass: "btn btn-danger",
                        attrs: {
                            type: "button"
                        },
                        on: {
                            click: function(e) {
                                return t.removeItem(n)
                            }
                        }
                    }, [a("i", {
                        staticClass: "fa fa-minus-circle"
                    })])])])
                })), t._v(" "), t.disabled ? t._e() : a("div", [a("div", {
                    staticClass: "input-group"
                }, [a("input", {
                    directives: [{
                        name: "model",
                        rawName: "v-model",
                        value: t.newItem,
                        expression: "newItem"
                    }],
                    staticClass: "form-control",
                    attrs: {
                        type: "text"
                    },
                    domProps: {
                        value: t.newItem
                    },
                    on: {
                        input: function(e) {
                            e.target.composing || (t.newItem = e.target.value)
                        }
                    }
                }), t._v(" "), a("span", {
                    staticClass: "input-group-btn",
                    staticStyle: {
                        width: "0"
                    }
                }), t._v(" "), a("select", {
                    directives: [{
                        name: "model",
                        rawName: "v-model",
                        value: t.newItemLevel,
                        expression: "newItemLevel"
                    }],
                    staticClass: "form-control",
                    on: {
                        change: function(e) {
                            const a = Array.prototype.filter.call(e.target.options, (function (t) {
                                return t.selected
                            })).map((function (t) {
                                return "_value" in t ? t._value : t.value
                            }));
                            t.newItemLevel = e.target.multiple ? a : a[0]
                        }
                    }
                }, [a("option", {
                    attrs: {
                        value: "1"
                    }
                }, [t._v(t._s(t.$t("Normal")))]), t._v(" "), a("option", {
                    attrs: {
                        value: "5"
                    }
                }, [t._v(t._s(t.$t("Global Read")))]), t._v(" "), a("option", {
                    attrs: {
                        value: "10"
                    }
                }, [t._v(t._s(t.$t("Admin")))])]), t._v(" "), a("span", {
                    staticClass: "input-group-btn"
                }, [a("button", {
                    staticClass: "btn btn-primary",
                    attrs: {
                        type: "button"
                    },
                    on: {
                        click: t.addItem
                    }
                }, [a("i", {
                    staticClass: "fa fa-plus-circle"
                })])])])])], 2)
            }), [], !1, null, "f290b6f6", null).exports
        },
        7732: (t, e, a) => {
            "use strict";
            a.r(e), a.d(e, {
                default: () => l
            });

            function n(t, e) {
                return function(t) {
                    if (Array.isArray(t)) return t
                }(t) || function(t, e) {
                    let a = null == t ? null : "undefined" != typeof Symbol && t[Symbol.iterator] || t["@@iterator"];
                    if (null == a) return;
                    let n, s;
                    const i = [];
                    let o = !0,
                        r = !1;
                    try {
                        for (a = a.call(t); !(o = (n = a.next()).done) && (i.push(n.value), !e || i.length !== e); o = !0);
                    } catch (t) {
                        r = !0, s = t
                    } finally {
                        try {
                            o || null == a.return || a.return()
                        } finally {
                            if (r) throw s
                        }
                    }
                    return i
                }(t, e) || i(t, e) || function() {
                    throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")
                }()
            }

            function s(t) {
                return function(t) {
                    if (Array.isArray(t)) return o(t)
                }(t) || function(t) {
                    if ("undefined" != typeof Symbol && null != t[Symbol.iterator] || null != t["@@iterator"]) return Array.from(t)
                }(t) || i(t) || function() {
                    throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")
                }()
            }

            function i(t, e) {
                if (t) {
                    if ("string" == typeof t) return o(t, e);
                    let a = Object.prototype.toString.call(t).slice(8, -1);
                    return "Object" === a && t.constructor && (a = t.constructor.name), "Map" === a || "Set" === a ? Array.from(t) : "Arguments" === a || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(a) ? o(t, e) : void 0
                }
            }

            function o(t, e) {
                (null == e || e > t.length) && (e = t.length);
                for (var a = 0, n = new Array(e); a < e; a++) n[a] = t[a];
                return n
            }
            const r = {
                name: "SettingMultiple",
                mixins: [a(9608).default],
                computed: {
                    formattedValue: function() {
                        let t;
                        if (void 0 === this.value) return [];
                        const e = this.value.toString().split(",");
                        return this.formatOptions((t = _).pick.apply(t, [this.options].concat(s(e))))
                    },
                    formattedOptions: function() {
                        return this.formatOptions(this.options)
                    }
                },
                methods: {
                    formatOptions: function(t) {
                        return Object.entries(t).map((function(t) {
                            const e = n(t, 2),
                                a = e[0];
                            return {
                                label: e[1],
                                value: a
                            }
                        }))
                    },
                    mutateInputEvent: function(t) {
                        return t.map((function(t) {
                            return t.value
                        })).join(",")
                    }
                }
            };
            const l = (0, a(1900).Z)(r, (function() {
                const t = this,
                    e = t.$createElement,
                    a = t._self._c || e;
                return a("div", [a("multiselect", {
                    attrs: {
                        value: t.formattedValue,
                        required: t.required,
                        disabled: t.disabled,
                        name: t.name,
                        label: "label",
                        "track-by": "value",
                        options: t.formattedOptions,
                        "allow-empty": !1,
                        multiple: !0
                    },
                    on: {
                        input: function(e) {
                            t.$emit("input", t.mutateInputEvent(e))
                        }
                    }
                })], 1)
            }), [], !1, null, "1656df74", null).exports
        },
        3493: (t, e, a) => {
            "use strict";
            a.r(e), a.d(e, {
                default: () => l
            });
            const n = {
                name: "SettingNull",
                props: ["name"]
            };
            const s = a(3379),
                i = a.n(s),
                o = a(7873),
                r = {
                    insert: "head",
                    singleton: !1
                };
            i()(o.Z, r);
            o.Z.locals;
            const l = (0, a(1900).Z)(n, (function() {
                const t = this,
                    e = t.$createElement;
                return (t._self._c || e)("div", [t._v("Invalid type for: " + t._s(t.name))])
            }), [], !1, null, "f45258b0", null).exports
        },
        4088: (t, e, a) => {
            "use strict";
            a.r(e), a.d(e, {
                default: () => l
            });
            const n = {
                name: "SettingOxidizedMaps",
                mixins: [a(9608).default],
                data: function() {
                    return {
                        mapModalIndex: null,
                        mapModalSource: null,
                        mapModalMatchType: null,
                        mapModalMatchValue: null,
                        mapModalTarget: null,
                        mapModalReplacement: null
                    }
                },
                methods: {
                    showModal: function(t) {
                        this.fillForm(t), this.$modal.show("maps")
                    },
                    submitModal: function() {
                        const t = this.maps,
                            e = {
                                target: this.mapModalTarget,
                                source: this.mapModalSource,
                                matchType: this.mapModalMatchType,
                                matchValue: this.mapModalMatchValue,
                                replacement: this.mapModalReplacement
                            };
                        this.mapModalIndex ? t[this.mapModalIndex] = e : t.push(e), console.log(t, e), this.updateValue(t)
                    },
                    fillForm: function(t) {
                        const e = this.maps.hasOwnProperty(t);
                        this.mapModalIndex = t, this.mapModalSource = e ? this.maps[t].source : null, this.mapModalMatchType = e ? this.maps[t].matchType : null, this.mapModalMatchValue = e ? this.maps[t].matchValue : null, this.mapModalTarget = e ? this.maps[t].target : null, this.mapModalReplacement = e ? this.maps[t].replacement : null
                    },
                    deleteItem: function(t) {
                        const e = this.maps;
                        e.splice(t, 1), this.updateValue(e)
                    },
                    updateValue: function(t) {
                        const e = {};
                        t.forEach((function(t) {
                            void 0 === e[t.target] && (e[t.target] = {}), void 0 === e[t.target][t.source] && (e[t.target][t.source] = []);
                            const a = {};
                            a[t.matchType] = t.matchValue, a.value = t.replacement, e[t.target][t.source].push(a)
                        })), this.$emit("input", e)
                    },
                    formatSource: function(t, e) {
                        return e.hasOwnProperty("regex") ? t + " ~ " + e.regex : e.hasOwnProperty("match") ? t + " = " + e.match : "invalid"
                    },
                    formatTarget: function(t, e) {
                        return t + " > " + (e.hasOwnProperty("value") ? e.value : e[t])
                    }
                },
                watch: {
                    updateStatus: function() {
                        "success" === this.updateStatus && this.$modal.hide("maps")
                    }
                },
                computed: {
                    maps: function() {
                        const t = this,
                            e = [];
                        return Object.keys(this.value).forEach((function(a) {
                            Object.keys(t.value[a]).forEach((function(n) {
                                t.value[a][n].forEach((function(t) {
                                    const s = t.hasOwnProperty("regex") ? "regex" : "match";
                                    e.push({
                                        target: a,
                                        source: n,
                                        matchType: s,
                                        matchValue: t[s],
                                        replacement: t.hasOwnProperty("value") ? t.value : t[a]
                                    })
                                }))
                            }))
                        })), e
                    }
                }
            };
            var s = a(3379),
                i = a.n(s),
                o = a(6634),
                r = {
                    insert: "head",
                    singleton: !1
                };
            i()(o.Z, r);
            o.Z.locals;
            const l = (0, a(1900).Z)(n, (function() {
                const t = this,
                    e = t.$createElement,
                    a = t._self._c || e;
                return a("div", [a("div", {
                    directives: [{
                        name: "show",
                        rawName: "v-show",
                        value: !t.disabled,
                        expression: "! disabled"
                    }],
                    staticClass: "new-btn-div"
                }, [a("button", {
                    staticClass: "btn btn-primary",
                    attrs: {
                        type: "button"
                    },
                    on: {
                        click: function(e) {
                            return t.showModal(null)
                        }
                    }
                }, [a("i", {
                    staticClass: "fa fa-plus"
                }), t._v(" " + t._s(t.$t("New Map Rule")))])]), t._v(" "), t._l(t.maps, (function(e, n) {
                    return a("div", {
                        staticClass: "panel panel-default"
                    }, [a("div", {
                        staticClass: "panel-body"
                    }, [a("div", {
                        staticClass: "col-md-5 expandable"
                    }, [a("span", [t._v(t._s(e.source) + " " + t._s("regex" === e.matchType ? "~" : "=") + " " + t._s(e.matchValue))])]), t._v(" "), a("div", {
                        staticClass: "col-md-4 expandable"
                    }, [a("span", [t._v(t._s(e.target) + " < " + t._s(e.replacement))])]), t._v(" "), a("div", {
                        staticClass: "col-md-3 buttons"
                    }, [a("div", {
                        directives: [{
                            name: "tooltip",
                            rawName: "v-tooltip",
                            value: !!t.disabled && t.$t("settings.readonly"),
                            expression: "disabled ? $t('settings.readonly') : false"
                        }],
                        staticClass: "btn-group"
                    }, [a("button", {
                        directives: [{
                            name: "tooltip",
                            rawName: "v-tooltip",
                            value: t.$t("Edit"),
                            expression: "$t('Edit')"
                        }],
                        staticClass: "btn btn-sm btn-info",
                        attrs: {
                            type: "button",
                            disabled: t.disabled
                        },
                        on: {
                            click: function(e) {
                                return t.showModal(n)
                            }
                        }
                    }, [a("i", {
                        staticClass: "fa fa-lg fa-edit"
                    })]), t._v(" "), a("button", {
                        directives: [{
                            name: "tooltip",
                            rawName: "v-tooltip",
                            value: t.$t("Delete"),
                            expression: "$t('Delete')"
                        }],
                        staticClass: "btn btn-sm btn-danger",
                        attrs: {
                            type: "button",
                            disabled: t.disabled
                        },
                        on: {
                            click: function(e) {
                                return t.deleteItem(n)
                            }
                        }
                    }, [a("i", {
                        staticClass: "fa fa-lg fa-remove"
                    })])])])])])
                })), t._v(" "), a("modal", {
                    attrs: {
                        name: "maps",
                        height: "auto"
                    }
                }, [a("div", {
                    staticClass: "modal-content"
                }, [a("div", {
                    staticClass: "modal-header"
                }, [a("button", {
                    staticClass: "close",
                    attrs: {
                        type: "button"
                    },
                    on: {
                        click: function(e) {
                            return t.$modal.hide("maps")
                        }
                    }
                }, [a("span", {
                    attrs: {
                        "aria-hidden": "true"
                    }
                }, [t._v("×")])]), t._v(" "), a("h4", {
                    staticClass: "modal-title"
                }, [t._v(t._s(t.mapModalIndex ? t.$t("Edit Map Rule") : t.$t("New Map Rule")))])]), t._v(" "), a("div", {
                    staticClass: "modal-body"
                }, [a("div", {
                    staticClass: "form-group"
                }, [a("label", {
                    staticClass: "col-sm-4 control-label",
                    attrs: {
                        for: "source"
                    }
                }, [t._v("Source")]), t._v(" "), a("div", {
                    staticClass: "col-sm-8"
                }, [a("select", {
                    directives: [{
                        name: "model",
                        rawName: "v-model",
                        value: t.mapModalSource,
                        expression: "mapModalSource"
                    }],
                    staticClass: "form-control",
                    attrs: {
                        id: "source"
                    },
                    on: {
                        change: function(e) {
                            const a = Array.prototype.filter.call(e.target.options, (function (t) {
                                return t.selected
                            })).map((function (t) {
                                return "_value" in t ? t._value : t.value
                            }));
                            t.mapModalSource = e.target.multiple ? a : a[0]
                        }
                    }
                }, [a("option", {
                    attrs: {
                        value: "hostname"
                    }
                }, [t._v("hostname")]), t._v(" "), a("option", {
                    attrs: {
                        value: "os"
                    }
                }, [t._v("os")]), t._v(" "), a("option", {
                    attrs: {
                        value: "type"
                    }
                }, [t._v("type")]), t._v(" "), a("option", {
                    attrs: {
                        value: "hardware"
                    }
                }, [t._v("hardware")]), t._v(" "), a("option", {
                    attrs: {
                        value: "sysObjectID"
                    }
                }, [t._v("sysObjectID")]), t._v(" "), a("option", {
                    attrs: {
                        value: "sysName"
                    }
                }, [t._v("sysName")]), t._v(" "), a("option", {
                    attrs: {
                        value: "sysDescr"
                    }
                }, [t._v("sysDescr")]), t._v(" "), a("option", {
                    attrs: {
                        value: "location"
                    }
                }, [t._v("location")]), t._v(" "), a("option", {
                    attrs: {
                        value: "ip"
                    }
                }, [t._v("ip")])])])]), t._v(" "), a("div", {
                    staticClass: "form-group"
                }, [a("label", {
                    staticClass: "col-sm-4",
                    attrs: {
                        for: "match_value"
                    }
                }, [a("select", {
                    directives: [{
                        name: "model",
                        rawName: "v-model",
                        value: t.mapModalMatchType,
                        expression: "mapModalMatchType"
                    }],
                    staticClass: "form-control",
                    attrs: {
                        id: "match_type"
                    },
                    on: {
                        change: function(e) {
                            const a = Array.prototype.filter.call(e.target.options, (function (t) {
                                return t.selected
                            })).map((function (t) {
                                return "_value" in t ? t._value : t.value
                            }));
                            t.mapModalMatchType = e.target.multiple ? a : a[0]
                        }
                    }
                }, [a("option", {
                    attrs: {
                        value: "match"
                    }
                }, [t._v("Match (=)")]), t._v(" "), a("option", {
                    attrs: {
                        value: "regex"
                    }
                }, [t._v("Regex (~)")])])]), t._v(" "), a("div", {
                    staticClass: "col-sm-8"
                }, [a("input", {
                    directives: [{
                        name: "model",
                        rawName: "v-model",
                        value: t.mapModalMatchValue,
                        expression: "mapModalMatchValue"
                    }],
                    staticClass: "form-control",
                    attrs: {
                        type: "text",
                        id: "match_value",
                        placeholder: ""
                    },
                    domProps: {
                        value: t.mapModalMatchValue
                    },
                    on: {
                        input: function(e) {
                            e.target.composing || (t.mapModalMatchValue = e.target.value)
                        }
                    }
                })])]), t._v(" "), a("div", {
                    staticClass: "form-horizontal",
                    attrs: {
                        role: "form"
                    }
                }, [a("div", {
                    staticClass: "form-group"
                }, [a("label", {
                    staticClass: "col-sm-4 control-label",
                    attrs: {
                        for: "target"
                    }
                }, [t._v("Target")]), t._v(" "), a("div", {
                    staticClass: "col-sm-8"
                }, [a("select", {
                    directives: [{
                        name: "model",
                        rawName: "v-model",
                        value: t.mapModalTarget,
                        expression: "mapModalTarget"
                    }],
                    staticClass: "form-control",
                    attrs: {
                        id: "target"
                    },
                    on: {
                        change: function(e) {
                            const a = Array.prototype.filter.call(e.target.options, (function (t) {
                                return t.selected
                            })).map((function (t) {
                                return "_value" in t ? t._value : t.value
                            }));
                            t.mapModalTarget = e.target.multiple ? a : a[0]
                        }
                    }
                }, [a("option", {
                    attrs: {
                        value: "os"
                    }
                }, [t._v("os")]), t._v(" "), a("option", {
                    attrs: {
                        value: "group"
                    }
                }, [t._v("group")]), t._v(" "), a("option", {
                    attrs: {
                        value: "ip"
                    }
                }, [t._v("ip")])])])]), t._v(" "), a("div", {
                    staticClass: "form-group"
                }, [a("label", {
                    staticClass: "col-sm-4 control-label",
                    attrs: {
                        for: "value"
                    }
                }, [t._v("Replacement")]), t._v(" "), a("div", {
                    staticClass: "col-sm-8"
                }, [a("input", {
                    directives: [{
                        name: "model",
                        rawName: "v-model",
                        value: t.mapModalReplacement,
                        expression: "mapModalReplacement"
                    }],
                    staticClass: "form-control",
                    attrs: {
                        type: "text",
                        id: "value",
                        placeholder: ""
                    },
                    domProps: {
                        value: t.mapModalReplacement
                    },
                    on: {
                        input: function(e) {
                            e.target.composing || (t.mapModalReplacement = e.target.value)
                        }
                    }
                })])]), t._v(" "), a("div", {
                    staticClass: "form-group"
                }, [a("div", {
                    staticClass: "col-sm-8 col-sm-offset-4"
                }, [a("button", {
                    staticClass: "btn btn-primary",
                    attrs: {
                        type: "button"
                    },
                    on: {
                        click: t.submitModal
                    }
                }, [t._v(t._s(t.$t("Submit")))])])])])])])])], 2)
            }), [], !1, null, "915dcab0", null).exports
        },
        4809: (t, e, a) => {
            "use strict";
            a.r(e), a.d(e, {
                default: () => s
            });
            const n = {
                name: "SettingPassword",
                mixins: [a(9608).default]
            };
            const s = (0, a(1900).Z)(n, (function() {
                const t = this,
                    e = t.$createElement;
                return (t._self._c || e)("input", {
                    staticClass: "form-control",
                    attrs: {
                        type: "password",
                        name: t.name,
                        pattern: t.pattern,
                        required: t.required,
                        disabled: t.disabled
                    },
                    domProps: {
                        value: t.value
                    },
                    on: {
                        input: function(e) {
                            return t.$emit("input", e.target.value)
                        }
                    }
                })
            }), [], !1, null, "452744d4", null).exports
        },
        8269: (t, e, a) => {
            "use strict";
            a.r(e), a.d(e, {
                default: () => s
            });
            const n = {
                name: "SettingSelect",
                mixins: [a(9608).default],
                methods: {
                    getText: function(t, e) {
                        const a = "settings.settings.".concat(t, ".options.").concat(e);
                        return this.$te(a) ? this.$t(a) : e
                    }
                }
            };
            const s = (0, a(1900).Z)(n, (function() {
                const t = this,
                    e = t.$createElement,
                    a = t._self._c || e;
                return a("select", {
                    staticClass: "form-control",
                    attrs: {
                        name: t.name,
                        required: t.required,
                        disabled: t.disabled
                    },
                    domProps: {
                        value: t.value
                    },
                    on: {
                        input: function(e) {
                            return t.$emit("input", e.target.value)
                        }
                    }
                }, t._l(t.options, (function(e, n) {
                    return a("option", {
                        domProps: {
                            value: n,
                            selected: t.value === n,
                            textContent: t._s(t.getText(t.name, e))
                        }
                    })
                })), 0)
            }), [], !1, null, "a6c05438", null).exports
        },
        3484: (t, e, a) => {
            "use strict";
            a.r(e), a.d(e, {
                default: () => s
            });
            const n = {
                name: "SettingSelectDynamic",
                mixins: [a(9608).default],
                data: function() {
                    return {
                        select2: null
                    }
                },
                watch: {
                    value: function(t) {
                        this.select2.val(t).trigger("change")
                    }
                },
                computed: {
                    settings: function() {
                        return {
                            theme: "bootstrap",
                            dropdownAutoWidth: !0,
                            width: "auto",
                            allowClear: Boolean(this.options.allowClear),
                            placeholder: this.options.placeholder,
                            ajax: {
                                url: route("ajax.select." + this.options.target).toString(),
                                delay: 250,
                                data: this.options.callback
                            }
                        }
                    }
                },
                mounted: function() {
                    const t = this;
                    axios.get(route("ajax.select." + this.options.target), {
                        params: {
                            id: this.value
                        }
                    }).then((function(e) {
                        e.data.results.forEach((function(e) {
                            e.id == t.value && t.select2.append(new Option(e.text, e.id, !0, !0)).trigger("change")
                        }))
                    })), this.select2 = $(this.$el).find("select").select2(this.settings).on("select2:select select2:unselect", (function(e) {
                        t.$emit("change", t.select2.val()), t.$emit("select", e.params.data)
                    }))
                },
                beforeDestroy: function() {
                    this.select2.select2("destroy")
                }
            };
            const s = (0, a(1900).Z)(n, (function() {
                const t = this,
                    e = t.$createElement,
                    a = t._self._c || e;
                return a("div", [a("select", {
                    staticClass: "form-control",
                    attrs: {
                        name: t.name,
                        required: t.required,
                        disabled: t.disabled
                    },
                    domProps: {
                        value: t.value
                    }
                })])
            }), [], !1, null, "b66d587a", null).exports
        },
        787: (t, e, a) => {
            "use strict";
            a.r(e), a.d(e, {
                default: () => l
            });
            const n = {
                name: "SettingSnmp3auth",
                mixins: [a(9608).default],
                data: function() {
                    return {
                        localList: this.value,
                        authAlgorithms: ["MD5", "AES"],
                        cryptoAlgorithms: ["AES", "DES"]
                    }
                },
                mounted: function() {
                    const t = this;
                    axios.get(route("snmp.capabilities")).then((function(e) {
                        t.authAlgorithms = e.data.auth, t.cryptoAlgorithms = e.data.crypto
                    }))
                },
                methods: {
                    addItem: function() {
                        this.localList.push({
                            authlevel: "noAuthNoPriv",
                            authalgo: "MD5",
                            authname: "",
                            authpass: "",
                            cryptoalgo: "AES",
                            cryptopass: ""
                        }), this.$emit("input", this.localList)
                    },
                    removeItem: function(t) {
                        this.localList.splice(t, 1), this.$emit("input", this.localList)
                    },
                    updateItem: function(t, e, a) {
                        this.localList[t][e] = a, this.$emit("input", this.localList)
                    },
                    dragged: function() {
                        this.$emit("input", this.localList)
                    }
                },
                watch: {
                    value: function(t) {
                        this.localList = t
                    }
                }
            };
            const s = a(3379),
                i = a.n(s),
                o = a(3938),
                r = {
                    insert: "head",
                    singleton: !1
                };
            i()(o.Z, r);
            o.Z.locals;
            const l = (0, a(1900).Z)(n, (function() {
                const t = this,
                    e = t.$createElement,
                    a = t._self._c || e;
                return a("div", [a("draggable", {
                    attrs: {
                        disabled: t.disabled
                    },
                    on: {
                        end: function(e) {
                            return t.dragged()
                        }
                    },
                    model: {
                        value: t.localList,
                        callback: function(e) {
                            t.localList = e
                        },
                        expression: "localList"
                    }
                }, t._l(t.localList, (function(e, n) {
                    return a("div", [a("div", {
                        staticClass: "panel panel-default"
                    }, [a("div", {
                        staticClass: "panel-heading"
                    }, [a("h3", {
                        staticClass: "panel-title"
                    }, [t._v(t._s(n + 1) + ". "), t.disabled ? t._e() : a("span", {
                        staticClass: "pull-right text-danger",
                        on: {
                            click: function(e) {
                                return t.removeItem(n)
                            }
                        }
                    }, [a("i", {
                        staticClass: "fa fa-minus-circle"
                    })])])]), t._v(" "), a("div", {
                        staticClass: "panel-body"
                    }, [a("form", {
                        on: {
                            onsubmit: function(t) {
                                t.preventDefault()
                            }
                        }
                    }, [a("div", {
                        staticClass: "form-group"
                    }, [a("div", {
                        staticClass: "col-sm-12"
                    }, [a("select", {
                        directives: [{
                            name: "model",
                            rawName: "v-model",
                            value: e.authlevel,
                            expression: "item.authlevel"
                        }],
                        staticClass: "form-control",
                        attrs: {
                            id: "authlevel",
                            disabled: t.disabled
                        },
                        on: {
                            change: [function(a) {
                                const n = Array.prototype.filter.call(a.target.options, (function (t) {
                                    return t.selected
                                })).map((function (t) {
                                    return "_value" in t ? t._value : t.value
                                }));
                                t.$set(e, "authlevel", a.target.multiple ? n : n[0])
                            }, function(e) {
                                return t.updateItem(n, e.target.id, e.target.value)
                            }]
                        }
                    }, [a("option", {
                        attrs: {
                            value: "noAuthNoPriv"
                        },
                        domProps: {
                            textContent: t._s(t.$t("settings.settings.snmp.v3.level.noAuthNoPriv"))
                        }
                    }), t._v(" "), a("option", {
                        attrs: {
                            value: "authNoPriv"
                        },
                        domProps: {
                            textContent: t._s(t.$t("settings.settings.snmp.v3.level.authNoPriv"))
                        }
                    }), t._v(" "), a("option", {
                        attrs: {
                            value: "authPriv"
                        },
                        domProps: {
                            textContent: t._s(t.$t("settings.settings.snmp.v3.level.authPriv"))
                        }
                    })])])]), t._v(" "), a("fieldset", {
                        directives: [{
                            name: "show",
                            rawName: "v-show",
                            value: "auth" === e.authlevel.toString().substring(0, 4),
                            expression: "item.authlevel.toString().substring(0, 4) === 'auth'"
                        }],
                        attrs: {
                            name: "algo",
                            disabled: t.disabled
                        }
                    }, [a("legend", {
                        staticClass: "h4",
                        domProps: {
                            textContent: t._s(t.$t("settings.settings.snmp.v3.auth"))
                        }
                    }), t._v(" "), a("div", {
                        staticClass: "form-group"
                    }, [a("label", {
                        staticClass: "col-sm-3 control-label",
                        attrs: {
                            for: "authalgo"
                        },
                        domProps: {
                            textContent: t._s(t.$t("settings.settings.snmp.v3.fields.authalgo"))
                        }
                    }), t._v(" "), a("div", {
                        staticClass: "col-sm-9"
                    }, [a("select", {
                        directives: [{
                            name: "model",
                            rawName: "v-model",
                            value: e.authalgo,
                            expression: "item.authalgo"
                        }],
                        staticClass: "form-control",
                        attrs: {
                            id: "authalgo",
                            name: "authalgo"
                        },
                        on: {
                            change: [function(a) {
                                const n = Array.prototype.filter.call(a.target.options, (function (t) {
                                    return t.selected
                                })).map((function (t) {
                                    return "_value" in t ? t._value : t.value
                                }));
                                t.$set(e, "authalgo", a.target.multiple ? n : n[0])
                            }, function(e) {
                                return t.updateItem(n, e.target.id, e.target.value)
                            }]
                        }
                    }, t._l(t.authAlgorithms, (function(e) {
                        return a("option", {
                            domProps: {
                                value: e,
                                textContent: t._s(e)
                            }
                        })
                    })), 0)])]), t._v(" "), a("div", {
                        staticClass: "form-group"
                    }, [a("label", {
                        staticClass: "col-sm-3 control-label",
                        attrs: {
                            for: "authname"
                        },
                        domProps: {
                            textContent: t._s(t.$t("settings.settings.snmp.v3.fields.authname"))
                        }
                    }), t._v(" "), a("div", {
                        staticClass: "col-sm-9"
                    }, [a("input", {
                        staticClass: "form-control",
                        attrs: {
                            type: "text",
                            id: "authname"
                        },
                        domProps: {
                            value: e.authname
                        },
                        on: {
                            input: function(e) {
                                return t.updateItem(n, e.target.id, e.target.value)
                            }
                        }
                    })])]), t._v(" "), a("div", {
                        staticClass: "form-group"
                    }, [a("label", {
                        staticClass: "col-sm-3 control-label",
                        attrs: {
                            for: "authpass"
                        },
                        domProps: {
                            textContent: t._s(t.$t("settings.settings.snmp.v3.fields.authpass"))
                        }
                    }), t._v(" "), a("div", {
                        staticClass: "col-sm-9"
                    }, [a("input", {
                        staticClass: "form-control",
                        attrs: {
                            type: "text",
                            id: "authpass"
                        },
                        domProps: {
                            value: e.authpass
                        },
                        on: {
                            input: function(e) {
                                return t.updateItem(n, e.target.id, e.target.value)
                            }
                        }
                    })])])]), t._v(" "), a("fieldset", {
                        directives: [{
                            name: "show",
                            rawName: "v-show",
                            value: "authPriv" === e.authlevel,
                            expression: "item.authlevel === 'authPriv'"
                        }],
                        attrs: {
                            name: "crypt",
                            disabled: t.disabled
                        }
                    }, [a("legend", {
                        staticClass: "h4",
                        domProps: {
                            textContent: t._s(t.$t("settings.settings.snmp.v3.crypto"))
                        }
                    }), t._v(" "), a("div", {
                        staticClass: "form-group"
                    }, [a("label", {
                        staticClass: "col-sm-3 control-label",
                        attrs: {
                            for: "cryptoalgo"
                        }
                    }, [t._v("Cryptoalgo")]), t._v(" "), a("div", {
                        staticClass: "col-sm-9"
                    }, [a("select", {
                        directives: [{
                            name: "model",
                            rawName: "v-model",
                            value: e.cryptoalgo,
                            expression: "item.cryptoalgo"
                        }],
                        staticClass: "form-control",
                        attrs: {
                            id: "cryptoalgo"
                        },
                        on: {
                            change: [function(a) {
                                const n = Array.prototype.filter.call(a.target.options, (function (t) {
                                    return t.selected
                                })).map((function (t) {
                                    return "_value" in t ? t._value : t.value
                                }));
                                t.$set(e, "cryptoalgo", a.target.multiple ? n : n[0])
                            }, function(e) {
                                return t.updateItem(n, e.target.id, e.target.value)
                            }]
                        }
                    }, t._l(t.cryptoAlgorithms, (function(e) {
                        return a("option", {
                            domProps: {
                                value: e,
                                textContent: t._s(e)
                            }
                        })
                    })), 0)])]), t._v(" "), a("div", {
                        staticClass: "form-group"
                    }, [a("label", {
                        staticClass: "col-sm-3 control-label",
                        attrs: {
                            for: "cryptopass"
                        },
                        domProps: {
                            textContent: t._s(t.$t("settings.settings.snmp.v3.fields.authpass"))
                        }
                    }), t._v(" "), a("div", {
                        staticClass: "col-sm-9"
                    }, [a("input", {
                        staticClass: "form-control",
                        attrs: {
                            type: "text",
                            id: "cryptopass"
                        },
                        domProps: {
                            value: e.cryptopass
                        },
                        on: {
                            input: function(e) {
                                return t.updateItem(n, e.target.id, e.target.value)
                            }
                        }
                    })])])])])])])])
                })), 0), t._v(" "), t.disabled ? t._e() : a("div", {
                    staticClass: "row snmp3-add-button"
                }, [a("div", {
                    staticClass: "col-sm-12"
                }, [a("button", {
                    staticClass: "btn btn-primary",
                    on: {
                        click: function(e) {
                            return t.addItem()
                        }
                    }
                }, [a("i", {
                    staticClass: "fa fa-plus-circle"
                }), t._v(" " + t._s(t.$t("New")))])])])], 1)
            }), [], !1, null, "b51be698", null).exports
        },
        9997: (t, e, a) => {
            "use strict";
            a.r(e), a.d(e, {
                default: () => s
            });
            const n = {
                name: "SettingText",
                mixins: [a(9608).default]
            };
            const s = (0, a(1900).Z)(n, (function() {
                const t = this,
                    e = t.$createElement;
                return (t._self._c || e)("input", {
                    staticClass: "form-control",
                    attrs: {
                        type: "text",
                        name: t.name,
                        pattern: t.pattern,
                        required: t.required,
                        disabled: t.disabled
                    },
                    domProps: {
                        value: t.value
                    },
                    on: {
                        input: function(e) {
                            return t.$emit("input", e.target.value)
                        }
                    }
                })
            }), [], !1, null, "8426bf9c", null).exports
        },
        3653: (t, e, a) => {
            "use strict";
            a.r(e), a.d(e, {
                default: () => s
            });
            const n = {
                name: "Tab",
                props: {
                    name: {
                        required: !0
                    },
                    text: String,
                    selected: {
                        type: Boolean,
                        default: !1
                    },
                    icon: String
                },
                data: function() {
                    return {
                        isActive: this.selected
                    }
                }
            };
            const s = (0, a(1900).Z)(n, (function() {
                const t = this,
                    e = t.$createElement;
                return (t._self._c || e)("div", {
                    directives: [{
                        name: "show",
                        rawName: "v-show",
                        value: t.isActive,
                        expression: "isActive"
                    }],
                    staticClass: "tab-pane",
                    attrs: {
                        role: "tabpanel",
                        id: t.name
                    }
                }, [t._t("default")], 2)
            }), [], !1, null, "1af9694b", null).exports
        },
        8872: (t, e, a) => {
            "use strict";
            a.r(e), a.d(e, {
                default: () => l
            });
            const n = {
                name: "Tabs",
                props: {
                    selected: String
                },
                data: function() {
                    return {
                        tabs: [],
                        activeTab: null
                    }
                },
                created: function() {
                    this.tabs = this.$children
                },
                mounted: function() {
                    this.activeTab = this.selected
                },
                watch: {
                    selected: function(t) {
                        this.activeTab = t
                    },
                    activeTab: function(t) {
                        this.tabs.forEach((function(e) {
                            return e.isActive = e.name === t
                        })), this.$emit("tab-selected", t)
                    }
                }
            };
            const s = a(3379),
                i = a.n(s),
                o = a(6682),
                r = {
                    insert: "head",
                    singleton: !1
                };
            i()(o.Z, r);
            o.Z.locals;
            const l = (0, a(1900).Z)(n, (function() {
                const t = this,
                    e = t.$createElement,
                    a = t._self._c || e;
                return a("div", [a("div", {
                    staticClass: "panel with-nav-tabs panel-default"
                }, [a("div", {
                    staticClass: "panel-heading"
                }, [a("ul", {
                    staticClass: "nav nav-tabs",
                    attrs: {
                        role: "tablist"
                    }
                }, [t._l(t.tabs, (function(e) {
                    return a("li", {
                        key: e.name,
                        class: {
                            active: e.isActive
                        },
                        attrs: {
                            role: "presentation"
                        }
                    }, [a("a", {
                        attrs: {
                            role: "tab",
                            "aria-controls": e.name
                        },
                        on: {
                            click: function(a) {
                                t.activeTab = e.name
                            }
                        }
                    }, [e.icon ? a("i", {
                        class: ["fa", "fa-fw", e.icon]
                    }) : t._e(), t._v("\n                        " + t._s(e.text || e.name) + " \n                    ")])])
                })), t._v(" "), a("li", {
                    staticClass: "pull-right"
                }, [t._t("header")], 2)], 2)]), t._v(" "), a("div", {
                    staticClass: "panel-body"
                }, [t._t("default")], 2)])])
            }), [], !1, null, "2ac3a533", null).exports
        },
        5606: (t, e, a) => {
            "use strict";
            a.r(e), a.d(e, {
                default: () => l
            });
            const n = {
                name: "TransitionCollapseHeight",
                methods: {
                    beforeEnter: function(t) {
                        requestAnimationFrame((function() {
                            t.style.height || (t.style.height = "0px"), t.style.display = null
                        }))
                    },
                    enter: function(t) {
                        requestAnimationFrame((function() {
                            requestAnimationFrame((function() {
                                t.style.height = t.scrollHeight + "px"
                            }))
                        }))
                    },
                    afterEnter: function(t) {
                        t.style.height = null
                    },
                    beforeLeave: function(t) {
                        requestAnimationFrame((function() {
                            t.style.height || (t.style.height = t.offsetHeight + "px")
                        }))
                    },
                    leave: function(t) {
                        requestAnimationFrame((function() {
                            requestAnimationFrame((function() {
                                t.style.height = "0px"
                            }))
                        }))
                    },
                    afterLeave: function(t) {
                        t.style.height = null
                    }
                }
            };
            const s = a(3379),
                i = a.n(s),
                o = a(1615),
                r = {
                    insert: "head",
                    singleton: !1
                };
            i()(o.Z, r);
            o.Z.locals;
            const l = (0, a(1900).Z)(n, (function() {
                const t = this,
                    e = t.$createElement;
                return (t._self._c || e)("transition", {
                    attrs: {
                        "enter-active-class": "enter-active",
                        "leave-active-class": "leave-active"
                    },
                    on: {
                        "before-enter": t.beforeEnter,
                        enter: t.enter,
                        "after-enter": t.afterEnter,
                        "before-leave": t.beforeLeave,
                        leave: t.leave,
                        "after-leave": t.afterLeave
                    }
                }, [t._t("default")], 2)
            }), [], !1, null, "54390bb4", null).exports
        },
        5642: (t, e, a) => {
            const n = {
                "./components/Accordion.vue": 4304,
                "./components/AccordionItem.vue": 1217,
                "./components/BaseSetting.vue": 9608,
                "./components/ExampleComponent.vue": 6784,
                "./components/LibrenmsSetting.vue": 3460,
                "./components/LibrenmsSettings.vue": 2872,
                "./components/PollerSettings.vue": 707,
                "./components/SettingArray.vue": 3334,
                "./components/SettingArraySubKeyed.vue": 2421,
                "./components/SettingBoolean.vue": 3554,
                "./components/SettingDirectory.vue": 573,
                "./components/SettingEmail.vue": 543,
                "./components/SettingExecutable.vue": 9844,
                "./components/SettingFloat.vue": 4517,
                "./components/SettingInteger.vue": 1707,
                "./components/SettingLdapGroups.vue": 7561,
                "./components/SettingMultiple.vue": 7732,
                "./components/SettingNull.vue": 3493,
                "./components/SettingOxidizedMaps.vue": 4088,
                "./components/SettingPassword.vue": 4809,
                "./components/SettingSelect.vue": 8269,
                "./components/SettingSelectDynamic.vue": 3484,
                "./components/SettingSnmp3auth.vue": 787,
                "./components/SettingText.vue": 9997,
                "./components/Tab.vue": 3653,
                "./components/Tabs.vue": 8872,
                "./components/TransitionCollapseHeight.vue": 5606
            };

            function s(t) {
                const e = i(t);
                return a(e)
            }

            function i(t) {
                if (!a.o(n, t)) {
                    const e = new Error("Cannot find module '" + t + "'");
                    throw e.code = "MODULE_NOT_FOUND", e
                }
                return n[t]
            }
            s.keys = function() {
                return Object.keys(n)
            }, s.resolve = i, t.exports = s, s.id = 5642
        }
    },
    t => {
        const e = e => t(t.s = e);
        t.O(0, [213, 170, 898], (() => (e(5377), e(4347), e(3848))));
        t.O()
    }
]);
