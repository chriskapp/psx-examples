<html>
<head>
	<!--<link rel="stylesheet" type="text/css" href="http://cdn.sencha.io/ext-4.2.0-gpl/resources/css/ext-all.css">-->
	<link rel="stylesheet" type="text/css" href="http://cdn.sencha.io/ext-4.2.0-gpl/resources/ext-theme-neptune/ext-theme-neptune-all.css">
	<script type="text/javascript" src="http://cdn.sencha.io/ext-4.2.0-gpl/ext-all.js"></script>
	<script type="text/javascript">
	Ext.onReady(function(){

		var format = Ext.create('Ext.data.Store', {
			fields: ['value', 'name'],
			data : [
				{"value": "json", "name": "json"},
				{"value": "jsonp", "name": "jsonp"},
				{"value": "xml", "name": "xml"},
				{"value": "atom", "name": "atom"}
			]
		});

		var column = Ext.create('Ext.data.Store', {
			fields: ['value', 'name'],
			data : [
				{"value": "id", "name": "id"},
				{"value": "place", "name": "place"},
				{"value": "region", "name": "region"},
				{"value": "population", "name": "population"},
				{"value": "users", "name": "users"},
				{"value": "world_users", "name": "world_users"},
				{"value": "datetime", "name": "datetime"}
			]
		});

		var op = Ext.create('Ext.data.Store', {
			fields: ['value', 'name'],
			data : [
				{"value": "contains", "name": "contains"},
				{"value": "equals", "name": "equals"},
				{"value": "startsWith", "name": "startsWith"},
				{"value": "present", "name": "present"}
			]
		});

		var order = Ext.create('Ext.data.Store', {
			fields: ['value', 'name'],
			data : [
				{"value": "ascending", "name": "ascending"},
				{"value": "descending", "name": "descending"}
			]
		});

		var panel = Ext.create('Ext.panel.Panel', {
			layout: 'border',
			region: 'center',
			border: 0,
			tbar: new Ext.Panel({
				border: 0,
				items: [{
					xtype: 'toolbar',
					border: 0,
					items: [Ext.create('Ext.form.field.ComboBox', {
						id: 'format',
						hideLabel: true,
						store: format,
						displayField: 'name',
						typeAhead: true,
						queryMode: 'local',
						triggerAction: 'all',
						emptyText: 'Select a format ...',
						selectOnFocus: true,
						editable: false,
						width: 100,
						value: 'xml'
					}), {
						id: 'fields',
						xtype: 'textfield',
						name: 'fields',
						emptyText: 'Fields',
						width: 160,
						value: ''
					},{
						id: 'startIndex',
						xtype: 'textfield',
						name: 'startIndex',
						emptyText: 'Start',
						width: 60,
						value: 0
					},{
						id: 'count',
						xtype: 'textfield',
						name: 'count',
						emptyText: 'Count',
						width: 60,
						value: 10
					}, Ext.create('Ext.form.field.ComboBox', {
						id: 'sortBy',
						hideLabel: true,
						store: column,
						displayField: 'name',
						typeAhead: true,
						queryMode: 'local',
						triggerAction: 'all',
						emptyText: 'Sort by ...',
						selectOnFocus: true,
						editable: false,
						width: 100
					}), Ext.create('Ext.form.field.ComboBox', {
						id: 'sortOrder',
						hideLabel: true,
						store: order,
						displayField: 'name',
						typeAhead: true,
						queryMode: 'local',
						triggerAction: 'all',
						emptyText: 'Sort order ...',
						selectOnFocus: true,
						editable: false,
						width: 100
					})]
				},{
					xtype: 'toolbar',
					border: 0,
					items: [Ext.create('Ext.form.field.ComboBox', {
						id: 'filterBy',
						hideLabel: true,
						store: column,
						displayField: 'name',
						typeAhead: true,
						queryMode: 'local',
						triggerAction: 'all',
						emptyText: 'Filter by ...',
						selectOnFocus: true,
						editable: false,
						width: 100
					}), Ext.create('Ext.form.field.ComboBox', {
						id: 'filterOp',
						hideLabel: true,
						store: op,
						displayField: 'name',
						typeAhead: true,
						queryMode: 'local',
						triggerAction: 'all',
						emptyText: 'Filter op ...',
						selectOnFocus: true,
						editable: false,
						width: 100
					}),{
						id: 'filterValue',
						xtype: 'textfield',
						name: 'filterValue',
						emptyText: 'Filter value',
						width: 188
					},{
						text: 'Filter',
						iconCls: 'icon-search',
						handler: function(){
							var url = '<?php echo $url . 'api/example'; ?>?';

							if (Ext.isString(Ext.getCmp('format').getValue())) {
								url+= 'format=' + Ext.getCmp('format').getValue() + '&';
							}

							if (Ext.isString(Ext.getCmp('fields').getValue())) {
								url+= 'fields=' + Ext.getCmp('fields').getValue() + '&';
							}

							if (Ext.isString(Ext.getCmp('startIndex').getValue())) {
								url+= 'startIndex=' + Ext.getCmp('startIndex').getValue() + '&';
							}

							if (Ext.isString(Ext.getCmp('count').getValue())) {
								url+= 'count=' + Ext.getCmp('count').getValue() + '&';
							}

							if (Ext.isString(Ext.getCmp('sortBy').getValue())) {
								url+= 'sortBy=' + Ext.getCmp('sortBy').getValue() + '&';
							}

							if (Ext.isString(Ext.getCmp('sortOrder').getValue())) {
								url+= 'sortOrder=' + Ext.getCmp('sortOrder').getValue() + '&';
							}

							if (Ext.isString(Ext.getCmp('filterBy').getValue())) {
								url+= 'filterBy=' + Ext.getCmp('filterBy').getValue() + '&';
							}

							if (Ext.isString(Ext.getCmp('filterOp').getValue())) {
								url+= 'filterOp=' + Ext.getCmp('filterOp').getValue() + '&';
							}

							if (Ext.isString(Ext.getCmp('filterValue').getValue())) {
								url+= 'filterValue=' + Ext.getCmp('filterValue').getValue();
							}

							Ext.get('api-iframe').set({'src': url});
						}
					}]
				}]
			}),
			items: [{
				region: 'center',
				html: '<iframe id="api-iframe" src="<?php echo $url . 'api/example'; ?>" style="width:100%;height:100%;border:none;"></iframe>',
				border: false
			}]
		});

		Ext.create('Ext.container.Viewport', {
			layout: 'border',
			items: [panel]
		});

	});
	</script>
	<style type="text/css">
	.icon-search
	{
		background-image:url(/img/icons/refresh.png);
	}
	</style>
</head>
<body>

</body>
</html>
