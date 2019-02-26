pimcore.registerNS("pimcore.plugin.AppBundle");

pimcore.plugin.AppBundle = Class.create(pimcore.plugin.admin, {
    getClassName: function () {
        return "pimcore.plugin.AppBundle";
    },

    initialize: function () {
        pimcore.plugin.broker.registerPlugin(this);
    },

    pimcoreReady: function (params, broker) {
        // alert("AppBundle ready!");
    }
});

var AppBundlePlugin = new pimcore.plugin.AppBundle();
