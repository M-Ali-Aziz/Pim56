pimcore.registerNS("pimcore.plugin.LucatBundle");

pimcore.plugin.LucatBundle = Class.create(pimcore.plugin.admin, {
    getClassName: function () {
        return "pimcore.plugin.LucatBundle";
    },

    initialize: function () {
        pimcore.plugin.broker.registerPlugin(this);

        // Adding Custom Main Navigation Items (Lucat).
        this.navEl = Ext.get('pimcore_menu_search').insertSibling('<li id="pimcore_menu_person" data-menu-tooltip="Lucat" class="pimcore_menu_item icon-person"></li>', 'after');
    },

    pimcoreReady: function (params, broker) {
        // Lucat click event
        this.navEl.on("click", function(){ lucat_gridpanel.showTab(); });

        // Add Lucat sync button under Tools in the main menu
        lucatSync.toolbar();
    }
});

var LucatBundlePlugin = new pimcore.plugin.LucatBundle();
