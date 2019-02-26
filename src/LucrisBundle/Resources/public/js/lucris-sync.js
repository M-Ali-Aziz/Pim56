var lucrisSync = {
    toolbar: function() {
        // add Lucris sync button under Tools in the main menu
        var layoutToolbar = pimcore.globalmanager.get("layout_toolbar");

        var action = new Ext.Action({
            id: "lucrissyncbtn_menu_item",
            text: "Synka Lucris",
            iconCls:"lucrissyncbtn_menu_icon",
            handler: lucrisSync.showTab
        });

        layoutToolbar.extrasMenu.add(action);
    },

    showTab: function () {
        var panelId = "lucrissyncbtn_check_panel";
        var tabPanel = Ext.getCmp("pimcore_panel_tabs");

        if (!Ext.get(Ext.query("#" + panelId)).elements.length) {
            lucrisSync.panel = new Ext.Panel({
                id:         "lucrissyncbtn_check_panel",
                title:      "Synka Lucris",
                iconCls:    "lucrissyncbtn_check_panel_icon",
                border:     false,
                bodyPadding: 12,
                closable:   true,
                items: lucrisSync.getItems()
            });

            tabPanel.add(lucrisSync.panel);
        }

        tabPanel.setActiveTab(lucrisSync.panel);
        pimcore.layout.refresh();
    },

    getItems: function () {
        var FormFieldSet = [{
            // Fieldset in Column 1 - Organisation sync
            xtype: 'fieldset',
            title: 'Synka Lucris Organisationer',
            items: [{
                xtype: 'button',
                text: 'Synka Lucris Organisation',
                renderTo: Ext.getBody(),
                handler: lucrisSync.syncLucrisOrganisation
            }]
        },  {
            // Fieldset in Column 1 - Person sync
            xtype: 'fieldset',
            title: 'Synka Lucris Personer',
            items: [{
                xtype: 'button',
                text: 'Synka Lucris Person',
                renderTo: Ext.getBody(),
                handler: lucrisSync.syncLucrisPerson
            }]
        }];

        return FormFieldSet;
    },

    syncing: false,

    syncMsg: null,

    syncLucrisOrganisation: function() {
        if (lucrisSync.syncing == true) {
            return;
        }

        lucrisSync.syncing = true;

        // Set message
        lucrisSync.syncMsg = Ext.MessageBox.alert('Var god vänta!!', 'Synkar Lucris Organisationer ...');

        // Making request to lucrisBundle -> defaultConroller -> organisationAction
        Ext.Ajax.request({
            url: "/lucris/sync/organisation",
            success: function(response, opts) {
                if (response.responseText.indexOf('ERROR') !== -1) {
                    lucrisSync.syncMsg.hide();
                    pimcore.helpers.showNotification('Error', response.responseText, 'error');
                    lucrisSync.syncing = false;
                    return;
                }

                lucrisSync.syncMsg.hide();
                pimcore.helpers.showNotification('Success', 'Synkning av LucrisOrganisation lyckades.', 'success');
                lucrisSync.syncing = false;
            },
            failure: function(response, opts) {
                lucrisSync.syncMsg.hide();
                pimcore.helpers.showNotification('Error', response.responseText, 'error');
                lucrisSync.syncing = false;
            }
        });
    },

    syncLucrisPerson: function() {
        if (lucrisSync.syncing == true) {
            return;
        }

        lucrisSync.syncing = true;

        // Set message
        lucrisSync.syncMsg = Ext.MessageBox.alert('Var god vänta!!', 'Synkar Lucris Personer ...');

        //Making request to index lucris conroller sync function
        Ext.Ajax.request({
            url: "/lucris/sync/person",
            success: function(response, opts) {
                if (response.responseText.indexOf('ERROR') !== -1) {
                    lucrisSync.syncMsg.hide();
                    pimcore.helpers.showNotification('Error', response.responseText, 'error');
                    lucrisSync.syncing = false;
                    return;
                }

                lucrisSync.syncMsg.hide();
                pimcore.helpers.showNotification('Success', 'Synkning av LucrisPerson lyckades.', 'success');
                lucrisSync.syncing = false;
            },
            failure: function(response, opts) {
                lucrisSync.syncMsg.hide();
                pimcore.helpers.showNotification('Error', response.responseText, 'error');
                lucrisSync.syncing = false;
            }
        });
    }
}
