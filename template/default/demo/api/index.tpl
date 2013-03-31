<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<link rel="stylesheet" type="text/css" href="http://cdn.sencha.io/ext-4.2.0-gpl/resources/css/ext-all.css">
	<script type="text/javascript" src="http://cdn.sencha.io/ext-4.2.0-gpl/ext-all.js"></script>
	<script type="text/javascript">
	Ext.onReady(function(){

		var format = Ext.create('Ext.data.Store', {
			fields: ['value', 'name'],
			data : [
				{"value": "json", "name": "json"},
				{"value": "xml", "name": "xml"},
				{"value": "atom", "name": "atom"},
				{"value": "rss", "name": "rss"}
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
			tbar: ['Format',Ext.create('Ext.form.field.ComboBox', {
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
			}),'Start',{
				id: 'startIndex',
				xtype: 'textfield',
				name: 'startIndex',
				emptyText: 'Start',
				width: 60,
				value: 0
			},'Count',{
				id: 'count',
				xtype: 'textfield',
				name: 'count',
				emptyText: 'Count',
				width: 60,
				value: 10
			},'Sort By',Ext.create('Ext.form.field.ComboBox', {
				id: 'sortBy',
				hideLabel: true,
				store: column,
				displayField: 'name',
				typeAhead: true,
				queryMode: 'local',
				triggerAction: 'all',
				emptyText: 'Select a column ...',
				selectOnFocus: true,
				editable: false,
				width: 100
			}),'Sort Order',Ext.create('Ext.form.field.ComboBox', {
				id: 'sortOrder',
				hideLabel: true,
				store: order,
				displayField: 'name',
				typeAhead: true,
				queryMode: 'local',
				triggerAction: 'all',
				emptyText: 'Select a order ...',
				selectOnFocus: true,
				editable: false,
				width: 100
			}),'Filter By',Ext.create('Ext.form.field.ComboBox', {
				id: 'filterBy',
				hideLabel: true,
				store: column,
				displayField: 'name',
				typeAhead: true,
				queryMode: 'local',
				triggerAction: 'all',
				emptyText: 'Select a column ...',
				selectOnFocus: true,
				editable: false,
				width: 100
			}),'Filter Op',Ext.create('Ext.form.field.ComboBox', {
				id: 'filterOp',
				hideLabel: true,
				store: op,
				displayField: 'name',
				typeAhead: true,
				queryMode: 'local',
				triggerAction: 'all',
				emptyText: 'Select a operator ...',
				selectOnFocus: true,
				editable: false,
				width: 100
			}),'Filter Value',{
				id: 'filterValue',
				xtype: 'textfield',
				name: 'filterValue',
				emptyText: 'Value'
			},'->',{
				text: 'Filter',
				iconCls: 'icon-search',
				handler: function(){
					var url = '<?php echo $url . 'demo/api/example'; ?>?';

					if (Ext.isString(Ext.getCmp('format').getValue())) {
						url+= 'format=' + Ext.getCmp('format').getValue() + '&';
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
			}],
			items: [{
				region: 'center',
				html: '<iframe id="api-iframe" src="<?php echo $url . 'demo/api/example'; ?>" style="width:100%;height:100%;border:none;"></iframe>',
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
