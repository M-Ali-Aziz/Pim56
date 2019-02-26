var lucatSync = {
    toolbar: function() {
        // add Lucat sync button under Tools in the main menu
        var layoutToolbar = pimcore.globalmanager.get("layout_toolbar");

        var action = new Ext.Action({
            id: "lucatsyncbtn_menu_item",
            text: "Synka Lucat",
            iconCls:"lucatsyncbtn_menu_icon",
            handler: lucatSync.showTab
        });

        layoutToolbar.extrasMenu.add(action);
    },

    showTab: function () {
        var panelId = "lucatsyncbtn_check_panel";
        var tabPanel = Ext.getCmp("pimcore_panel_tabs");

        if (!Ext.get(Ext.query("#" + panelId)).elements.length) {
            lucatSync.panel = new Ext.Panel({
                id:         "lucatsyncbtn_check_panel",
                title:      "Synka Lucat",
                iconCls:    "lucatsyncbtn_check_panel_icon",
                border:     false,
                bodyPadding: 12,
                closable:   true,
                items: lucatSync.getItems()
            });

            tabPanel.add(lucatSync.panel);
        }

        tabPanel.setActiveTab(lucatSync.panel);
        pimcore.layout.refresh();
    },

    getItems: function () {
        var FormFieldSet = [{
            xtype: 'fieldset',
            title: 'Synka Lucat',
            items: [{
                xtype: 'button',
                text: 'Synka Lucat',
                renderTo: Ext.getBody(),
                handler: lucatSync.syncLucat
            }]
        }];

        return FormFieldSet;
    },

    syncing: false,

    syncMsg: null,

    syncLucat: function() {
        if (lucatSync.syncing == true) {
            return;
        }

        lucatSync.syncing = true;

        // Set message
        lucatSync.syncMsg = Ext.MessageBox.alert('Var god vänta!!', 'Synkar Lucat ...');

        // Making request to lucatBundle -> defaultConroller -> organisationAction
        Ext.Ajax.request({
            url: "/lucat/sync/lucat",
            success: function(response, opts) {
                if (response.responseText.indexOf('ERROR') !== -1) {
                    lucatSync.syncMsg.hide();
                    pimcore.helpers.showNotification('Error', response.responseText, 'error');
                    lucatSync.syncing = false;
                    return;
                }

                lucatSync.syncMsg.hide();
                pimcore.helpers.showNotification('Success', 'Synkning av Lucat lyckades.', 'success');
                lucatSync.syncing = false;
            },
            failure: function(response, opts) {
                lucatSync.syncMsg.hide();
                pimcore.helpers.showNotification('Error', response.responseText, 'error');
                lucatSync.syncing = false;
            }
        });
    }
}