(function() {
	tinymce.PluginManager.add('tcbd_modals_mce_button', function( editor, url ) {
		editor.addButton( 'tcbd_modals_mce_button', {
			icon: false,
			type: 'button',
			title: 'TCBD Modals',
			image : url + '/icon.png',
			onclick: function() {
				editor.windowManager.open( {
					title: 'Text Title',
					body: [
						{
							type: 'textbox',
							name: 'texttitleBox',
							label: 'Text'
						},
						{
							type: 'textbox',
							name: 'modalstitleBox',
							label: 'Modals Title'
						},
						{
							type: 'textbox',
							name: 'modalscontentBox',
							label: 'Modals Text',
							multiline: true,
							minWidth: 300,
							minHeight: 150
						}
					],
					onsubmit: function( e ) {
						editor.insertContent( '[tcbd-modals title="' + e.data.modalstitleBox + '" text="' + e.data.modalscontentBox + '"]' + e.data.texttitleBox + '[/tcbd-modals]');
					}
				});
			}
		});
	});
})();