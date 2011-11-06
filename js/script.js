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
                if(data.success != true) return false;
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
                return s;
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
                if(data.success != true) return false;
                V.fetch(V.currentTeam);
            return data;
            }
        }); 
    },
    "refreshChart": function(scores) {
        var V = this;
        $('div.agenda-item', V.$chart).each(function(i) {
            $(this).animate({width: scores[i-1]*40-7}, 1000);
        });
    }
};


$(function() {
//    Votes.init();
	var tabs = $('ul.section_tabs')
	tabi = 0;
	$('.arrow.left').click(function(){
		if (tabi > 0){
			tabi -= 1;
			tabs.animate({top: '+=50'})
		} 
	})
	$('.arrow.right').click(function(){
		if (tabi < 7){
			tabi += 1;
			tabs.animate({top: '-=50'})
		} 
	})
	tabs.find('li').click(function(){
		var teamName = $(this).find('span').html()
		var teamID = $(this).data('team')
		$(this).addClass('selected').siblings().removeClass('selected');
		$('#left_col_team_name').html(teamName).data('team', teamID)
		//TODO Fetch All And Refresh Scores
	})
	$('#current-track').click(function(){
		$('#filter').toggleClass('selected')
		
	})
	$('#filter-table td').click(function(){
		$('#filter').removeClass('selected')
		//TODO SEND SCORE OF TEAM TO BACKEND
		var score = $(this).data('score')
		Votes.vote(score)
	})
});
