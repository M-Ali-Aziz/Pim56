pimcore.registerNS("pimcore.plugin.LucrisBundle");

pimcore.plugin.LucrisBundle = Class.create(pimcore.plugin.admin, {
    getClassName: function () {
        return "pimcore.plugin.LucrisBundle";
    },

    initialize: function () {
        pimcore.plugin.broker.registerPlugin(this);
    },

    pimcoreReady: function (params, broker) {
        // alert("LucrisBundle ready!");
    }
});

var LucrisBundlePlugin = new pimcore.plugin.LucrisBundle();
