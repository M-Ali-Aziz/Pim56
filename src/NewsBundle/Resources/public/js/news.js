pimcore.registerNS("pimcore.plugin.NewsBundle");

pimcore.plugin.NewsBundle = Class.create(pimcore.plugin.admin, {
    getClassName: function () {
        return "pimcore.plugin.NewsBundle";
    },

    initialize: function () {
        pimcore.plugin.broker.registerPlugin(this);

        // Adding Custom Main Navigation Items (Nyheter).
        this.navEl = Ext.get('pimcore_menu_search').insertSibling('<li id="pimcore_menu_news" data-menu-tooltip="Nyheter" class="pimcore_menu_item icon-news"></li>', 'after');
    },

    pimcoreReady: function (params, broker) {
        // alert("NewsBundle ready!");

        // Nyheter click event
        this.navEl.on("click", function(){ news.showTab(); });
    }
});

var NewsBundlePlugin = new pimcore.plugin.NewsBundle();
