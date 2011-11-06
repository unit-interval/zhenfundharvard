var Param = {
	"teams" : "10",
	"judges" : "5"
};
var Votes = {
	"init" : function() {
		this.cache = {};
		this.currentTeam = 1;

		this.$chart = $('#spaces_section div.left_col');
		this.$list = $('#spaces_section div.rank_list ul')

		this.update();
	},
	"update" : function() {
		var V =this
		//this.fetch_all();
		for(var i = 1; i <= Param.teams; i++)
		this.fetch(i);
		V.refreshRanking(0)
	},
	"fetch_all" : function() {
	},
	"fetch" : function(id) {
		var V = this;
		$.ajax({
			type : "get",
			data : 'id=' + id,
			url : 'fetch-score.php',
			cache : false,
			dataType : 'json',
			success : function(data) {
				if(data.success != true) {
					data.score=[]
					for(var i = 0; i <= 15; i++)
						data.score.push(0)
				}
				var sum = 0;
				var s = [];
				for(var i = 0; i < Param.judges; i++) {
					s.push(data.score[i]);
					sum += data.score[i];
				}
				s.push(data.score[15]);
				s.push((sum / Param.judges + data.score[15]) / 2);
				V.cache[id] = s;
				if(id == V.currentTeam)
					V.refreshChart(s);
				return s;
			}
		});
	},
	"vote" : function(score) {
		var V = this;
		$.ajax({
			type : 'post',
			data : 'score=' + score + '&team_id=' + V.currentTeam,
			url : 'vote.php',
			cache : false,
			dataType : 'json',
			success : function(data) {
				if(data.success != true)
					return false;
				V.fetch(V.currentTeam);
				return data;
			}
		});
	},
	"refreshChart" : function(scores) {
		var V = this;
		$('div.agenda-item', V.$chart).each(function(i) {
			var score = scores[i]
			$(this).animate({
				width : Math.max(score * 40 - 7,33)
			});
		});
		total = scores[scores.length - 1] * 10
		$('#info-balloon').animate({
			left : 157+total/100*(340-157)
		})
		var rand = $('#info-balloon>h4').html() * 1; ( inloop = function() {
			if(rand > total) {
				$('#info-balloon>h4').html((rand -= 1.1).toFixed(1));
			} else {
				$('#info-balloon>h4').html((rand += 1.1).toFixed(1));
			}
			if(Math.abs(rand - total) < 2) {
				$('#info-balloon>h4').html(total.toFixed(1));
				return 0;
			}
			clr = setTimeout(inloop, 20);
		})();
	},
	"refreshRanking": function(i) {
		if (i>=Param.teams) return false;
		for (j=0; j<i; j++)
			if 
		if (j==i) return false;
		var V = this;
		var l=$('div.rank-list')
		var a=$('li:eq('+i+')', l);
		var b=$('li:eq('+j+')', l);
		a.slideUp(function(){
			$(this).remove().insertBefore(b).slideDown();
			V.refreshRanking(i+1)
		})
		return false;
	}
};

$(function() {
	Votes.init();
	var tabs = $('ul.section_tabs')
	tabi = 0;
	$('.arrow.left').click(function() {
		if(tabi > 0) {
			tabi -= 1;
			tabs.animate({
				top : '+=50'
			})
		}
	})
	$('.arrow.right').click(function() {
		if(tabi < Param.teams / 5 - 1) {
			tabi += 1;
			tabs.animate({
				top : '-=50'
			})
		}
	})
	tabs.find('li').click(function() {
		var teamName = $(this).find('span').html()
		var teamID = $(this).data('team')
		$(this).addClass('selected').siblings().removeClass('selected');
		$('#left_col_team_name').html(teamName).data('team', teamID)
		Votes.currentTeam = teamID
		Votes.fetch(teamID)
	})
	$('#current-track').click(function() {
		$('#filter').toggleClass('selected')
	})
	$('#filter-table td').click(function() {
		$('#filter').removeClass('selected')
		//DONE SEND SCORE OF TEAM TO BACKEND
		var score = $(this).data('score')
		Votes.vote(score)
	})
});