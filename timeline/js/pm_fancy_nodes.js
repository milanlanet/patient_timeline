(function ($) {
        $(".tree").fancytree({
                extensions: ["dnd", "edit"],
                source: {url: $('#node_url').val()},
                lazyLoad: function (event, data) {
                        data.result = {url: "ajax-sub2.json", debugDelay: 1000};
                },
                dnd: {
                        autoExpandMS: 400,
                        focusOnClick: true,
                        preventVoidMoves: true, // Prevent dropping nodes 'before self', etc.
                        preventRecursiveMoves: true, // Prevent dropping nodes on own descendants
                        dragStart: function (node, data) {
                                /** This function MUST be defined to enable dragging for the tree.
                                 *  Return false to cancel dragging of node.
                                 */
                                return true;
                        },
                        dragEnter: function (node, data) {
                                /** data.otherNode may be null for non-fancytree droppables.
                                 *  Return false to disallow dropping on node. In this case
                                 *  dragOver and dragLeave are not called.
                                 *  Return 'over', 'before, or 'after' to force a hitMode.
                                 *  Return ['before', 'after'] to restrict available hitModes.
                                 *  Any other return value will calc the hitMode from the cursor position.
                                 */
                                // Prevent dropping a parent below another parent (only sort
                                // nodes under the same parent)
                                /* 					if(node.parent !== data.otherNode.parent){
                                 return false;
                                 }
                                 // Don't allow dropping *over* a node (would create a child)
                                 return ["before", "after"];
                                 */
                                return true;
                        },
                        dragDrop: function (node, data) {
                                /** This function MUST be defined to enable dropping of items on
                                 *  the tree.
                                 */
                                data.otherNode.moveTo(node, data.hitMode);
                        }
                },
                edit: {
                        triggerStart: ["f2", "dblclick", "shift+click", "mac+enter"],
                        beforeEdit: function (event, data) {
                                // Return false to prevent edit mode
                        },
                        edit: function (event, data) {
                                // Editor was opened (available as data.input)
                        },
                        beforeClose: function (event, data) {
                                // Return false to prevent cancel/save (data.input is available)
                        },
                        save: function (event, data) {
                                // Save data.input.val() or return false to keep editor open
                                console.log("save...", this, data);
                                // Simulate to start a slow ajax request...
                                setTimeout(function () {
                                        $(data.node.span).removeClass("pending");
                                        // Let's pretend the server returned a slightly modified
                                        // title:
                                        data.node.setTitle(data.node.title + "!");
                                }, 2000);
                                // We return true, so ext-edit will set the current user input
                                // as title
                                return true;
                        },
                        close: function (event, data) {
                                // Editor was removed
                                if (data.save) {
                                        // Since we started an async request, mark the node as preliminary
                                        $(data.node.span).addClass("pending");
                                }
                        }
                }
        });

        $(".tree").contextmenu({
                delegate: "span.fancytree-title",
//			menu: "#options",
                menu: [
                        {title: "Image", cmd: "image", uiIcon: "ui-icon-scissors"},
                        {title: "Video", cmd: "video", uiIcon: "ui-icon-copy"},
                        {title: "template", cmd: "template", uiIcon: "ui-icon-clipboard", disabled: false},
                ],
                beforeOpen: function (event, ui) {
                        var node = $.ui.fancytree.getNode(ui.target);
//                node.setFocus();
                        node.setActive();
                },
                select: function (event, ui) {
                        var node = $.ui.fancytree.getNode(ui.target);
                        alert("select " + ui.cmd + " on " + node);
                }
        });

        addSampleButton({
                label: "Add Node",
                newline: false,
                code: function () {
                        var node = $(".tree").fancytree("getActiveNode");
                        node.editCreateNode("after", "Node title");
                }
        });

        addSampleButton({
                label: "Add Sub Node",
                newline: false,
                code: function () {
                        var node = $(".tree").fancytree("getActiveNode");
                        if (!node) {
                                alert("Please Select a parent node.");
                                return;
                        }
                        node.editCreateNode("child", "Node title");
                }
        });


})(jQuery); 