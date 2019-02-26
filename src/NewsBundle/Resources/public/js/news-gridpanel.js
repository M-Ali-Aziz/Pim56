var news = {
    
    user: function() { return pimcore.globalmanager.get("user"); },

    showTab: function() {

        var panelId = "lu_news_panel";
        var tabPanel = Ext.getCmp("pimcore_panel_tabs");
        
        if (!Ext.get(Ext.query("#" + panelId)).elements.length) {

            news.panel = new Ext.Panel({
                id:         panelId,
                title:      'Nyheter',
                iconCls:    "pimcore_icon_news",
                border:     false,
                layout:     "fit",
                closable:   true,
                items:      [news.getGrid()],
                // buttons:    []
            });

            tabPanel.add(news.panel);
        }
        
        tabPanel.setActiveItem(news.panel);
        pimcore.layout.refresh();
    },

    getGrid: function() {

        var itemsPerPage = 30;
        var url = '/news/ajax/get-news?';
        var fields = ['Rubrik', 'Webb', 'o_creationDate','o_modificationDate','o_userModification','o_published','o_id','o_key', 'o_userOwner'];
        for(var i=0; i<fields.length; i++) {
            url += 'fields%5B%5D=' + fields[i] + '&';
        }

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

        news.store = Ext.create('Ext.data.Store', {
            proxy: proxy,
            autoLoad: false,
            autoSync: true,
            pageSize: itemsPerPage,
            fields: fields,
            remoteSort: true,
            remoteFilter: true
        });

        // specify segment of data you want to load using params
        news.store.load({
            params: {
                start: 0,
                limit: itemsPerPage
            }
        });

        news.users = [];
        Ext.Ajax.request({
            url: '/news/ajax/get-users',
            params: {},
            success: function(response){
                news.users = JSON.parse(response.responseText);
            }
        });

        news.pagingtoolbar = pimcore.helpers.grid.buildDefaultPagingToolbar(news.store, itemsPerPage);

        news.filterField = new Ext.form.TextField({
            xtype: "textfield",
            width: 200,
            style: "margin: 0 10px 0 0;",
            enableKeyEvents: true,
            listeners: {
                "keydown" : function (field, key) {
                    if (key.getKey() == key.ENTER) {
                        var input = field;
                        var proxy = news.store.getProxy();
                        proxy.extraParams.filter = input.getValue();
                        news.store.load();
                    }
                }
            }
        });

        var typesColumns = [
            {header: t("id"), flex: 50, sortable: true, dataIndex: 'o_id', editor: new Ext.form.TextField({}), editable: false, hidden: true},
            {header: t("title"), flex: 300, sortable: true, dataIndex: 'Rubrik', editor: new Ext.form.TextField({}), editable: false},
            {header: t("website"), flex: 100, sortable: true, dataIndex: 'Webb', editor: new Ext.form.TextField({}), editable: false,
                renderer: function(d) {
                    if (d !== undefined && d !== null) {
                        return d.join(', ');
                    } else {
                        return "";
                    }
                }
            },
            {header: 'Permalink', flex: 150, sortable: true, dataIndex: 'o_key', editor: new Ext.form.TextField({}), editable: false},

            {header: t("published"), flex: 40, sortable: true, dataIndex: 'o_published', editor: new Ext.form.TextField({}), editable: false,
                renderer: function(d) {
                    return (d) ? 'Yes' : 'No';
                }
            },

            {header: 'Created By', flex: 150, dataIndex: 'o_userOwner', editable: false, renderer: function(d) {
                var userOwnerTag = null;
                news.users.forEach(function(user) {
                    if(user.id == d) {
                        userOwnerTag = user.firstname + ' ' + user.lastname;
                    }
                });
                return userOwnerTag;
            }},

            {header: t("creationDate"), sortable: true, dataIndex: 'o_creationDate', editable: false,
                hidden: false,
                width: 150,
                renderer: function(d) {
                    if (d !== undefined) {
                        var date = new Date(d * 1000);
                        return Ext.Date.format(date, "Y-m-d H:i");
                    } else {
                        return "";
                    }
                }
            },
            {header: t("modificationDate"), sortable: true, dataIndex: 'o_modificationDate', editable: false,
                hidden: false,
                width: 150,
                renderer: function(d) {
                    if (d !== undefined) {
                        var date = new Date(d * 1000);
                        return Ext.Date.format(date, "Y-m-d H:i");
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
                    iconCls: "pimcore_icon_add",
                    text: t("add"),
                    xtype: "button",
                    handler: function() {

                        Ext.Ajax.request({
                            url: '/news/ajax/create-object',
                            params: {userId: news.user().id},
                            success: function(response){
                                response = JSON.parse(response.responseText);
                                if(response.success) {
                                    pimcore.helpers.openObject(response.id, "news");
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
                news.filterField
            ]
        });

        news.grid = Ext.create('Ext.grid.Panel', {
            frame: false,
            autoScroll: true,
            store: this.store,
            columns : typesColumns,
            trackMouseOver: true,
            columnLines: true,
            bodyCls: "pimcore_editable_grid",
            selModel: Ext.create('Ext.selection.RowModel', {}),
            //sm: Ext.create('Ext.grid.RowSelectionModel',{singleSelect:true}),
            listeners: {
                rowclick: function(grid, rowIndex, e) {
                    pimcore.helpers.openObject(rowIndex.data.o_id, "news");
                }
            },
            stripeRows: true,
            dockedItems: [{
                xtype: 'pagingtoolbar',
                store: this.store,
                dock: 'bottom',
                displayInfo: true
            }],
            tbar: toolbar,
            viewConfig: {
                forceFit: true,
                listeners: {
                    //rowupdated: this.updateRows.bind(this),
                    //refresh: this.updateRows.bind(this)
                }
            }
        });

        //this.store.on("update", this.updateRows.bind(this));
        //this.grid.on("viewready", this.updateRows.bind(this));

        return news.grid;
    }

}