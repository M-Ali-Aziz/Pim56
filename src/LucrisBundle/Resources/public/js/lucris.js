pimcore.registerNS("pimcore.plugin.LucrisBundle");

pimcore.plugin.LucrisBundle = Class.create(pimcore.plugin.admin, {
    getClassName: function () {
        return "pimcore.plugin.LucrisBundle";
    },

    initialize: function () {
        pimcore.plugin.broker.registerPlugin(this);
    },

    pimcoreReady: function (params, broker) {
        // add Lucris sync button under Tools in the main menu
        lucrisSync.toolbar();
    }
});

var LucrisBundlePlugin = new pimcore.plugin.LucrisBundle();
