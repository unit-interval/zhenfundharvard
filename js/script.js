var Param = { "teams": "30", "judges": "5" };
var Votes = {
    "init": function() {
        this.cache = {};
        this.update();
    },
    "update": function() {
        this.fetch(0);
//        this.refreshRanking();
    },
    "fetch": function(id) {
        var V = this;
        $.ajax({
            type: "get",
            data: 'id=' + id,
            url: 'fetch-score.php',
            cache: false,
            dataType: 'json',
            success: function(data){
                if(data.success != true) return;
                var avg;
                var s;
                for (var team in data.score) {
                    sum = 0;
                    s = []
                    for (var i = 0; i++ < Param.judges - 1; ) {
                        s.push(data.score[team][i]);
                        sum += data.score[team][i];
                    }
                    s.push(data.score[team][15]);
                    s.push((sum / (Param.judges - 1) + data.score[team][15]) / 2); 
                    V.cache[team] = s;
                }
            }
        });
    }
}

function refreshChart(ts) {
    $('div.agenda-item').each(function(i){
        $(this).animate({width: ts[i]*40-7}, 1000);
    })
}


