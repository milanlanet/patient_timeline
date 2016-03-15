( function() {
    tinymce.PluginManager.add( 'wpeditimage', function( editor, url ) {

        // Add a button that opens a window
        editor.addButton( 'fb', {

            text: 'FB Test Button',
            icon: false,
            onclick: function() {
                // Open window
                editor.windowManager.open( {
                    title: 'Example plugin',
                    body: [{
                        type: 'textbox',
                        name: 'title',
                        label: 'Title'
                    }],
                    onsubmit: function( e ) {
                        // Insert content when the window form is submitted
                        editor.insertContent( 'Title: ' + e.data.title );
                    }

                } );
            }

        } );

    } );

} )();