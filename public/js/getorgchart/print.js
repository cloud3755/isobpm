
getOrgChart.prototype._printHandler = function (sender, args) {
    this.print();
}


getOrgChart.prototype.print = function () {

    var chart = this,
        container = this._elements.element,
        toolbox = this._elements._toolbar,
        origDisplay = [],
        origParent = container.parentNode,
        origToolbox = toolbox.style.display,
        body = document.body,
        childNodes = body.childNodes,         
        i;


    if (chart._isPrinting) { // block the button while in printing mode
        return;
    }

    chart._isPrinting = true;

    // hide all body content
    for (i = 0; i < childNodes.length; i++) {
        var node = childNodes[i];
        if (node.nodeType === 1){            
            origDisplay[i] = node.style.display;
            node.style.display = "none";
        }
    }

    toolbox.style.display = "none";

    //// pull out the chart
    body.appendChild(container);    

    // print
    window.focus(); 
    window.print();

    // allow the browser to prepare before reverting
    setTimeout(function () {

        // put the chart back in
        origParent.appendChild(container);

        for (i = 0; i < childNodes.length; i++) {
            var node = childNodes[i];
            if (node.nodeType === 1) {
                node.style.display = origDisplay[i];
            }
        }

        toolbox.style.display = origToolbox;

        chart._isPrinting = false;

    }, 1000);
}
