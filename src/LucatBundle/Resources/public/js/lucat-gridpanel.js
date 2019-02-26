var lucat_gridpanel = {

    gridUrl:    "/lucat/gridpanel/get?",
    exportUrl:  "/lucat/gridpanel/export?",
    usersUrl:   "/lucat/gridpanel/get-users",
    fields: [
        'role.o_creationDate','role.o_modificationDate',
        'role.o_userModification','role.o_published','role.o_id','role.o_key',
        'role.o_userOwner', 'per.displayName', 'per.givenName', 'per.surName',
        'per.uid', 'per.luMail', 'role.displayName', 'org.name',
        'role.primaryContactInfo','role.leaveOfAbsence','role.hideFromWeb'
    ],

    fieldsSearch: ['displayName','uid'],

    showTab: function(){
        var panelId = "lu_person_panel";
        var tabPanel = Ext.getCmp("pimcore_panel_tabs");
        
        if (!Ext.get(Ext.query("#" + panelId)).elements.length) {

            lucat_gridpanel.panel = new Ext.Panel({
                id:         panelId,
                title:      "Lucat",
                iconCls:    "pimcore_icon_person",
                border:     false,
                layout:     "fit",
                closable:   true,
                items:      [lucat_gridpanel.getGrid()]
            });

            tabPanel.add(lucat_gridpanel.panel);
        }

        tabPanel.setActiveItem(lucat_gridpanel.panel);
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

        var itemsPerPage = 30;
        var url = lucat_gridpanel.gridUrl;
        // object
        // url += lucat_gridpanel.composeQueryString('object', ['person']);
        // fields
        url += lucat_gridpanel.composeQueryString('fields', lucat_gridpanel.fields);
        // search fields
        url += lucat_gridpanel.composeQueryString('searchFields', lucat_gridpanel.fieldsSearch);

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

        lucat_gridpanel.store = Ext.create('Ext.data.Store', {
            proxy: proxy,
            autoLoad: false,
            autoSync: true,
            pageSize: itemsPerPage,
            fields: lucat_gridpanel.fields,
            remoteSort: true,
            remoteFilter: true
        });

        // specify segment of data you want to load using params
        lucat_gridpanel.store.load({
            params: {
                start: 0,
                limit: itemsPerPage
            }
        });

        lucat_gridpanel.users = [];
        Ext.Ajax.request({
            url: lucat_gridpanel.usersUrl,
            params: {},
            success: function(response){
                lucat_gridpanel.users = JSON.parse(response.responseText);
            }
        });

        lucat_gridpanel.pagingtoolbar = pimcore.helpers.grid.buildDefaultPagingToolbar(lucat_gridpanel.store, itemsPerPage);

        lucat_gridpanel.filterField = new Ext.form.TextField({
            xtype: "textfield",
            width: 200,
            style: "margin: 0 10px 0 0;",
            enableKeyEvents: true,
            listeners: {
                "keydown" : function (field, key) {
                    if (key.getKey() == key.ENTER) {
                        var input = field;
                        var proxy = lucat_gridpanel.store.getProxy();
                        proxy.extraParams.filter = input.getValue();
                        lucat_gridpanel.store.load();
                    }
                }
            }
        });

        var typesColumns = [
            {header: t("id"), flex: 50, sortable: true, dataIndex: 'o_id', editor: new Ext.form.TextField({}), editable: false, hidden: true},

            {header: 'Förnamn', flex: 120, sortable: true, dataIndex: 'per.givenName', editor: new Ext.form.TextField({}), editable: false},
            {header: 'Efternamn', flex: 120, sortable: true, dataIndex: 'per.surName', editor: new Ext.form.TextField({}), editable: false},
            {header: 'Lucat-ID', flex: 80, sortable: true, dataIndex: 'per.uid', editor: new Ext.form.TextField({}), editable: false},
            {header: 'E-post', flex: 150, sortable: true, dataIndex: 'per.luMail', editor: new Ext.form.TextField({}), editable: false},
            {header: 'Verksamhetsroll', flex: 150, sortable: true, dataIndex: 'role.displayName', editor: new Ext.form.TextField({}), editable: false},
            {header: 'Enhet', flex: 150, sortable: true, dataIndex: 'org.name', editor: new Ext.form.TextField({}), editable: false},
            {header: 'Primär roll', flex: 50, sortable: true, dataIndex: 'role.primaryContactInfo', editor: new Ext.form.TextField({}), editable: false, renderer: function(d) { return (parseInt(d) > 0) ? "x" : ""; }},
            {header: 'Tjänstledig', flex: 50, sortable: true, dataIndex: 'role.leaveOfAbsence', editor: new Ext.form.TextField({}), editable: false, renderer: function(d) { return (parseInt(d) > 0) ? "x" : ""; }},
            {header: 'Osynlig', flex: 50, sortable: true, dataIndex: 'role.hideFromWeb', editor: new Ext.form.TextField({}), editable: false, renderer: function(d) { return (parseInt(d) > 0) ? "x" : ""; }},

            {header: t("creationDate"), sortable: true, dataIndex: 'role.o_creationDate', editable: false,
                hidden: false,
                width: 150,
                renderer: function(d) {
                    if (d !== undefined) {
                        var date = new Date(d * 1000);
                        return Ext.Date.format(date, "Y-m-d H:i:s");
                    } else {
                        return "";
                    }
                }
            },
            {header: t("modificationDate"), sortable: true, dataIndex: 'role.o_modificationDate', editable: false,
                hidden: false,
                width: 150,
                renderer: function(d) {
                    if (d !== undefined) {
                        var date = new Date(d * 1000);
                        return Ext.Date.format(date, "Y-m-d H:i:s");
                    } else {
                        return "";
                    }
                }
            }
        ];

        var object_tree = pimcore.globalmanager.get("layout_object_tree");
        //var object_tree = new pimcore.object.tree();
        var toolbar = Ext.create('Ext.Toolbar', {
            cls: 'main-toolbar',
            items: [
                {
                    xtype: "button",
                    text: t("export_csv"),
                    iconCls: "pimcore_icon_export",
                    handler: function () {

                        var queryString = lucat_gridpanel.composeQueryString('fields', lucat_gridpanel.fields);                        
                        pimcore.helpers.download(Ext.urlAppend(lucat_gridpanel.exportUrl, queryString));

                    }
                },
                {
                    xtype: "button",
                    text: t("export_csv")+' Mail',
                    iconCls: "pimcore_icon_export",
                    handler: function () {

                        var queryString = lucat_gridpanel.composeQueryString('fields', ['per.uid', 'per.givenName', 'per.surName', 'per.luMail']);
                        queryString += '&unique=luMail';
                        pimcore.helpers.download(Ext.urlAppend(lucat_gridpanel.exportUrl, queryString));

                    }
                }, "->", {
                    text: t("filter") + "/" + t("search"),
                    xtype: "tbtext",
                    style: "margin: 0 10px 0 0;"
                },
                lucat_gridpanel.filterField
            ]
        });

        lucat_gridpanel.grid = Ext.create('Ext.grid.Panel', {
            frame: false,
            autoScroll: true,
            store: lucat_gridpanel.store,
            columns : typesColumns,
            trackMouseOver: true,
            columnLines: true,
            bodyCls: "pimcore_editable_grid",
            selModel: Ext.create('Ext.selection.RowModel', {}),
            //sm: Ext.create('Ext.grid.RowSelectionModel',{singleSelect:true}),
            listeners: {
                rowclick: function(grid, rowIndex, e) {
                    pimcore.helpers.openObject(rowIndex.data.o_id, "lucatperson");
                }
            },
            stripeRows: true,
            dockedItems: [{
                xtype: 'pagingtoolbar',
                store: lucat_gridpanel.store,
                dock: 'bottom',
                displayInfo: true
            }],
            tbar: toolbar,
            viewConfig: {
                forceFit: true,
                listeners: {
                    //rowupdated: lucat_gridpanel.updateRows.bind(lucat_gridpanel),
                    //refresh: lucat_gridpanel.updateRows.bind(lucat_gridpanel)
                }
            }
        });

        //lucat_gridpanel.store.on("update", lucat_gridpanel.updateRows.bind(lucat_gridpanel));
        //lucat_gridpanel.grid.on("viewready", lucat_gridpanel.updateRows.bind(lucat_gridpanel));

        return lucat_gridpanel.grid;
    }
};