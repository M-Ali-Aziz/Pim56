pimcore.registerNS("pimcore.plugin.LucatBundle");

pimcore.plugin.LucatBundle = Class.create(pimcore.plugin.admin, {
    getClassName: function () {
        return "pimcore.plugin.LucatBundle";
    },

    initialize: function () {
        pimcore.plugin.broker.registerPlugin(this);
    },

    pimcoreReady: function (params, broker) {
        // alert("LucatBundle ready!");
    }
});

var LucatBundlePlugin = new pimcore.plugin.LucatBundle();
