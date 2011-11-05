var Param = { "teams": "10", "judges": "5" };
var Votes = {
    "init": function() {
        this.cache = {};
        this.currentTeam = 1;

        this.$chart = $('#spaces_section div.left_col');

        this.update();
    },
    "update": function() {
//        this.fetch_all();
        for (var i = 1; i++ <= Param.teams; )
            this.fetch(i);
    },
    "fetch_all": function() {
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
                if (id == V.currentTeam)
                    V.refreshChart(s);
        //      V.refreshRanking();
            }
        });
    },
    "vote": function(score) {
        var V = this;
        $.ajax({
            type: 'post',
            data: 'score=' + score + '&team_id=' + V.currentTeam,
            url: 'vote.php',
            cache: false,
            dataType: 'json',
            success: function(data) {
                if(data.success != true) return;
                V.fetch(V.currentTeam);
            }
        }); 
    },
    "refreshChart": function(scores) {
        var V = this;
        $('div.agenda-item', V.$chart).each(function(i) {
            $(this).animate({width: scores[i]*40-7}, 1000);
        });
    }
};


$(function() {
//    Votes.init();
});
