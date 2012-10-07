<html>
<head>
	<title>PSX Demonstration</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta http-equiv="content-style-type" content="text/css" />
	<meta name="generator" content="psx" />
	<link rel="stylesheet" type="text/css" href="http://cdn.sencha.io/ext-4.1.0-gpl/resources/css/ext-all.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $base ?>/css/browse.css" />
	<link rel="icon" href="<?php echo $base ?>/img/favicon.ico" type="image/x-icon" />
	<script type="text/javascript" src="http://cdn.sencha.io/ext-4.1.0-gpl/ext-all.js"></script>
	<script type="text/javascript">
	Ext.ns('PSX');
	PSX.url = '<?php echo $url; ?>';
	Ext.ns('PSX.example');

	PSX.example.Content = Ext.extend(Ext.Panel, {

		initComponent: function(){
			var me = this;

			var config = {
				title: 'Content',
				region: 'center',
				margins: '5 5 5 0',
				bodyPadding: 8,
				border: true,
				html: '<iframe src="' + PSX.url + '/demo" width="100%" height="100%" frameBorder="0"></iframe>'
			};
			Ext.apply(me, config);

			me.callParent();
		},

		loadContent: function(url){
			this.body.update('<iframe src="' + url + '" width="100%" height="100%" frameBorder="0"></iframe>');
		}

	});

	PSX.example.Navigation = Ext.extend(Ext.tree.TreePanel, {

		initComponent: function(){
			var me = this;

			Ext.define('PSX.example.NavItem', {
				 extend: 'Ext.data.Model',
				 fields: [
					 {name: 'text', type: 'string'},
					 {name: 'source', type: 'string'},
					 {name: 'leaf', type: 'boolean'}
				 ]
			});

			var store = Ext.create('Ext.data.TreeStore', {
				model: 'PSX.example.NavItem',
				proxy: {
					type: 'ajax',
					url: PSX.url + '/navigation'
				},
				root: {
					text: 'psx',
					id: 'root',
					expanded: true
				}
			});

			var config = {
				title: 'Examples',
				region: 'west',
				margins: '5 5 5 5',
				width: 200,
				border: true,
				collapsible: false,
				rootVisible: true,
				singleExpand: false,
				autoScroll: true,
				containerScroll: true,
				useArrows: false,
				store: store
			};
			Ext.apply(me, config);

			me.callParent();
		}

	});

	PSX.example.Layout = Ext.extend(Ext.Viewport, {

		navigation: null,
		content: null,

		initComponent: function(){
			var me = this;

			this.navigation = Ext.create('PSX.example.Navigation');
			this.navigation.on('itemclick', this.handleNav, this);

			this.content = Ext.create('PSX.example.Content');

			var config = {
				layout: 'border',
				items: [this.navigation, this.content]
			};
			Ext.apply(me, config);

			me.callParent();
		},

		handleNav: function(el, rec){
			if (rec.parentNode == null) {
				this.content.loadContent(PSX.url + '/demo');
			} else if (rec.data.source) {
				this.content.loadContent(rec.data.source);
			}
		}

	});

	Ext.onReady(function(){
		new PSX.example.Layout();
	});
	</script>
</head>
<body>

</body>
</html>
