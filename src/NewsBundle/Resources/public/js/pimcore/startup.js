pimcore.registerNS("pimcore.plugin.NewsBundle");

pimcore.plugin.NewsBundle = Class.create(pimcore.plugin.admin, {
    getClassName: function () {
        return "pimcore.plugin.NewsBundle";
    },

    initialize: function () {
        pimcore.plugin.broker.registerPlugin(this);
    },

    pimcoreReady: function (params, broker) {
        // alert("NewsBundle ready!");
    }
});

var NewsBundlePlugin = new pimcore.plugin.NewsBundle();
