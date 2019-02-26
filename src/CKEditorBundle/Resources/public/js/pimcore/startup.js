pimcore.registerNS("pimcore.plugin.CKEditorBundle");

pimcore.plugin.CKEditorBundle = Class.create(pimcore.plugin.admin, {
    getClassName: function () {
        return "pimcore.plugin.CKEditorBundle";
    },

    initialize: function () {
        pimcore.plugin.broker.registerPlugin(this);

    pimcoreReady: function (params, broker) {
        // alert("CKEditorBundle ready!");
    }
});

var CKEditorBundlePlugin = new pimcore.plugin.CKEditorBundle();
