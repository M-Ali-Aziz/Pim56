var events = {
    gridUrl:    "/events/ajax/get?",
    createUrl:  "/events/ajax/create-object",
    usersUrl:   "/events/ajax/get-users",
    fields:     ['o_published','o_id','o_key', 'o_userOwner', 'Rubrik', 'Webb', 'o_creationDate', 'Start', 'Category', 'Serie'],
    fieldsSearch:  ['o_key'],

    user: function() { return pimcore.globalmanager.get("user"); },

    showTab: function() {

        var panelId = "lu_events_panel";
        var tabPanel = Ext.getCmp("pimcore_panel_tabs");

        if (!Ext.get(Ext.query("#" + panelId)).elements.length) {

            events.panel = new Ext.Panel({
                id:         panelId,
                title:      "Kalender",
                iconCls:    "pimcore_icon_events",
                border:     false,
                layout:     "fit",
                closable:   true,
                items:      [events.getGrid()]
            });

            tabPanel.add(events.panel);
        }

        tabPanel.setActiveItem(events.panel);
        pimcore.layout.refresh();
    },

    composeQueryString: function(name, fields) {
        var url = '';
        for(var i=0; i<fields.length; i++) {
            url += name + '%5B%5D=' + fields[i] + '&';
        }
        return url;
    },

    getGrid: function() {
        var itemsPerPage = 100;
        var url = events.gridUrl; // /events/ajax/get?
        // fields
        url += events.composeQueryString('fields', events.fields);
        // search fields
        url += events.composeQueryString('searchFields', events.fieldsSearch);

        var proxy = new Ext.data.proxy.Ajax({
            type: 'ajax',
            reader: {
                type: 'json',
                rootProperty: 'data',
                totalProperty: 'total'
            },
            actionMethods: {
                read   : 'POST'
            },
            api: {
                //create  : url + "xaction=create",
                read    : url + "xaction=read",
                //update  : url + "xaction=update",
                //destroy : url + "xaction=destroy"
            },
            listeners: {
                exception: function(proxy, response, operation){
                    Ext.MessageBox.show({
                        title: 'REMOTE EXCEPTION',
                        msg: operation.getError(),
                        icon: Ext.MessageBox.ERROR,
                        buttons: Ext.Msg.OK
                    });
                }
            }
        });

        events.store = Ext.create('Ext.data.Store', {
            proxy: proxy,
            autoLoad: false,
            autoSync: true,
            pageSize: itemsPerPage,
            fields: events.fields,
            remoteSort: true,
            remoteFilter: true
        });

        // specify segment of data you want to load using params
        events.store.load({
            params: {
                start: 0,
                limit: itemsPerPage
            }
        });

        events.users = [];
        Ext.Ajax.request({
            url: events.usersUrl,
            params: {},
            success: function(response){
                events.users = JSON.parse(response.responseText);
            }
        });

        events.pagingtoolbar = pimcore.helpers.grid.buildDefaultPagingToolbar(events.store, itemsPerPage);

        events.filterField = new Ext.form.TextField({
            xtype: "textfield",
            width: 200,
            style: "margin: 0 10px 0 0;",
            enableKeyEvents: true,
            listeners: {
                "keydown" : function (field, key) {
                    if (key.getKey() == key.ENTER) {
                        var input = field;
                        var proxy = events.store.getProxy();
                        proxy.extraParams.filter = input.getValue();
                        events.store.load();
                    }
                }
            }
        });

        var typesColumns = [
            {text: t("id"), flex: 70, sortable: true, dataIndex: 'o_id', editable: false, hidden: true},
            {text: 'Title', flex: 210, sortable: true, dataIndex: 'Rubrik', editable: false},
            {text: 'Category', flex: 60, sortable: true, dataIndex: 'Category', editable: false},
            {text: 'Series', flex: 60, sortable: true, dataIndex: 'Serie', editable: false},
            {text: "Eventdate (start)", sortable: true, dataIndex: 'Start', editable: false, hidden: false, width: 150},
            {text: 'Website', flex: 60, sortable: true, dataIndex: 'Webb', editable: false},
            //{text: 'Check', flex: 40, sortable: true, dataIndex: 'Check', editable: false, renderer: function(d) { return (d) ? 'Yes' : 'No'; }},
            {text: 'Published', flex: 40, sortable: true, dataIndex: 'o_published', editable: false, renderer: function(d) { return (d) ? 'Yes' : 'No'; }},
            {text: 'Created by', flex: 70, sortable: true, dataIndex: 'o_userOwner', editable: false, renderer: function(d) {
                var userOwnerTag = null;
                events.users.forEach(function(user) {
                    if(user.id == d) {
                        userOwnerTag = user.firstname + ' ' + user.lastname;
                    }
                });
                return userOwnerTag;
            }},

            {text: "Created", sortable: true, dataIndex: 'o_creationDate', editable: false,
                hidden: false,
                width: 150,
                renderer: function(d) {
                    if (d !== undefined && d !== null) {
                        var date = new Date(d * 1000);
                        return Ext.Date.format(date, "Y-m-d H:i");
                    } else {
                        return "";
                    }
                }
            }
        ];

        var toolbar = Ext.create('Ext.Toolbar', {
            cls: 'main-toolbar',
            items: [
                {
                    iconCls: "pimcore_icon_add",
                    text: t("add"),
                    xtype: "button",
                    handler: function() {
                        Ext.Ajax.request({
                            url: '/events/ajax/create-object',
                            params: {userId: events.user().id},
                            success: function(response){
                                response = JSON.parse(response.responseText);
                                if(response.success) {
                                    pimcore.helpers.openObject(response.id, "events");
                                } else {
                                    pimcore.helpers.showNotification('Error', response.message, 'error');
                                }
                            }
                        });
                    }
                },
                , "->", {
                    text: t("filter") + "/" + t("search"),
                    xtype: "tbtext",
                    style: "margin: 0 10px 0 0;"
                },
                events.filterField
            ]
        });

        events.grid = Ext.create('Ext.grid.Panel', {
            frame: false,
            scrollable: true,
            store: events.store,
            columns : typesColumns,
            columnLines: true,
            listeners: {
                rowclick: function(grid, rowIndex, e) {
                    pimcore.helpers.openObject(rowIndex.data.o_id, "events");
                }
            },
            dockedItems: [{
                xtype: 'pagingtoolbar',
                store: events.store,
                dock: 'bottom',
                displayInfo: true
            }],
            tbar: toolbar
        });

        return events.grid;
    }
}