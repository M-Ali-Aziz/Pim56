pimcore.registerNS("pimcore.plugin.EventsBundle");

pimcore.plugin.EventsBundle = Class.create(pimcore.plugin.admin, {
    getClassName: function () {
        return "pimcore.plugin.EventsBundle";
    },

    initialize: function () {
        pimcore.plugin.broker.registerPlugin(this);

        // Adding Custom Main Navigation Items (Kalender).
        this.navEl = Ext.get('pimcore_menu_search').insertSibling('<li id="pimcore_menu_events" data-menu-tooltip="Kalender" class="pimcore_menu_item icon-events"></li>', 'after');
    },

    pimcoreReady: function (params, broker) {
        // alert("EventsBundle ready!");

        // Kalender/Events click event
        this.navEl.on("click", function(){ events.showTab(); });
    }
});

var EventsBundlePlugin = new pimcore.plugin.EventsBundle();
