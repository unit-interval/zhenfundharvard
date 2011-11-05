var Param = { "teams": "30", "judges": "5" };
var Votes = {
    "init": function() {
        this.cache = {};
        this.update();
    },
    "update": function() {
        for (var i = 1; i++ <= Param.teams; )
            this.fetch(i);
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
                var sum = 0;
                var s = [];
                for (var i = 0; i++ < Param.judges -1; ) {
                    s.push(data.score[i]);
                    sum += data.score[i];
                }
                s.push(data.score[15]);
                s.push((sum / (Param.judges -1) + data.score[15]) / 2);
                V.cache[id] = s;
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


