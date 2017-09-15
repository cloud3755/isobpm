
getOrgChart.prototype._keydownHandler = function (sender, args) {
    var e = args[0];
    
    switch (e.keyCode) {
        case 37:
            this.move("left");
            break;
        case 38:
            this.move("down");
            break;
        case 39:
            this.move("right");
            break;
        case 40:
            this.move("up");
            break;
        case 107:
            this.zoom(1, true);
            break;
        case 109:
            this.zoom(-1, true);
            break;
    }
}
