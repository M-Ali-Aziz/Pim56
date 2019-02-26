pimcore.registerNS("pimcore.plugin.EventsBundle");

pimcore.plugin.EventsBundle = Class.create(pimcore.plugin.admin, {
    getClassName: function () {
        return "pimcore.plugin.EventsBundle";
    },

    initialize: function () {
        pimcore.plugin.broker.registerPlugin(this);
    },

    pimcoreReady: function (params, broker) {
        // alert("EventsBundle ready!");
    }
});

var EventsBundlePlugin = new pimcore.plugin.EventsBundle();
