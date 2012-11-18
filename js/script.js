var Param = {
	"teams" : 6,
	"judges" : 7,
	"ratio": 1
};
var Votes = {
	"init" : function() {
		this.cache = {};
		this.currentTeam = 1;
		this.refreshing = 0;

		this.$chart = $('#spaces_section div.left_col');
		this.$list = $('#spaces_section div.rank-list ul');

		this.fetch();
	},
    "ready": function() {
		var V = this;
        var rank = [];
        var $li = $("<li><span>•</span><label></label><span class='rank-score'></span><div class='bullet_square'></div></li>");
        var $s;
        for (var team in V.cache)
            rank.push(team);
        var len = rank.length;
        rank.sort(V.sortByScore);
        for (var i=0; i < len; i++) {
            $s = $li.clone().data('team', rank[i]).appendTo(V.$list)
                .find('label').html('TEAM ' + rank[i]).end()
                .find('span.rank-score').html((V.cache[rank[i]][Param.judges + 1]).toFixed(2));
//			$s = s + "<li data-team='"+rank[i]+"'><span>• TEAM "+rank[i]+"</span><span class='rank-score'>"+(V.cache[rank[i]][Param.judges+1]*10).toFixed(1)+"</span></li>"
        }
        for (var team=1; team<=Param.teams; team++)
        	if (! (team in V.cache))
                $s = $li.clone().data('team', team).addClass('hidden').appendTo(V.$list)
                    .find('label').html('TEAM ' + team).end()
                    .find('span.rank-score').html('0.0');
//        		s = s + "<li style='display:none' data-team='"+team+"'><span>• TEAM "+team+"</span><span class='rank-score'>0.0</span></li>"
//      V.$list.html(s);
		V.ranking_animation(0);
		return true;
    },
    "ranking_animation": function(t){
    	var V=this;
    	var i=0;
    	V.refreshing = 0;
    	if (V.refreshing > 0) return false;
    	$('li',V.$list).each(function(){
    		if (!$(this).hasClass('hidden')) {
    			V.refreshing++;
    			$(this).animate({ 'margin-top': i*75+10 }, t, function() {
    				V.refreshing--;
    			});
    			i++;
    		}
    		else {
    			$(this).animate({ 'margin-top': Param.teams * 75 + 10 }, 0);
    		}
    	})
    },
	"fetch" : function() {
		var V = this;
		$.ajax({
			type : "get",
			data : 'id=0',
			url : 'fetch-score.php',
			cache : false,
			dataType : 'json',
			success : function(data) {
				if(data.success != true)
                    return false;
                for (var id in data.scores)
                    V.write(id, data.scores[id]);
				V.once = V.once || V.ready();
                V.refreshChart();
			},
            error: function() {
                V.fetch();
            }
		});
	},
    "write": function(id, score) {
        var s = score.slice(0,Param.judges);
        var sum = 0;
//				var min = 100;
//				var max = 0;
        for (var i =0; i < Param.judges; i++) {
					sum += score[i];
//					if (score[i] < min) min = score[i]
//					if (score[i] > max) max = score[i]
				}
//				var avg = (sum - max - min) / (Param.judges - 2)
				var avg = sum / Param.judges
        s.push(score[15]);
        s.push(avg * Param.ratio + score[15] * (1 - Param.ratio));
        this.cache[id] = s;
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
				$('#filter').removeClass('selected')
				V.fetch(0);
			},
            error: function() {
                V.vote(score);
            }
		});
	},
	"refreshChart" : function() {
		var V = this;
		var n = Param.judges;
		var scores = []
		if (V.currentTeam in V.cache)
			scores = V.cache[V.currentTeam]; 
		else
			for (var i = 0; i < n + 2; i++) scores.push(0);
		var total = scores[n+1];
		$('div.agenda-item', V.$chart).each(function(i) {
			if (i < n) {
				$(this).animate({ width : Math.max(scores[i] * 4, 0) });	
			}
		});
		$('div.agenda-row.sum .agenda-item').animate({ width : Math.max(total * 4, 0) });
		$('#info-balloon').animate({ left : Math.floor(90 + total / 100 * (340 - 148)) })
		var rand = $('#info-balloon>h4').html() * 1.0;
		( inloop = function() {
			if(Math.abs(rand - total) < 1) {
				$('#info-balloon>h4').html(total.toFixed(2));
				return 0;
			}
			if(rand > total) $('#info-balloon>h4').html((rand -= 1.1).toFixed(2));
			else $('#info-balloon>h4').html((rand += 1.1).toFixed(2));
			setTimeout(inloop, 20);
		})();
	},
    "sortByScore": function(a,b) {
        var pos = Param.judges + 1;
        var c = Votes.cache;
        if(c[a][pos] < c[b][pos])
            return 1;
        else if(c[a][pos] > c[b][pos])
            return -1;
        else if(c[a][pos - 1] < c[b][pos - 1])
            return -1;
        else if(c[a][pos - 1] > c[b][pos - 1])
            return 1;
        else
            return 0;
    },
	"refreshRanking" : function() {
		var V = this;
		var $a, $b;
		var l = V.$list;
		if (V.refreshing > 0) return false;
		for (var i = 0; i < Param.teams; i++) {
			$a = $('li:eq(' + i + ')', l);
			an = $a.data('team')
			if (an in V.cache) {
				$('span.rank-score', $a).html((V.cache[an][Param.judges + 1]).toFixed(2));
				if ($a.hasClass('hidden'))
					$a.removeClass('hidden');
				for (var j = 0; j < i; j++) {
					$b = $('li:eq(' + j + ')', l);
					bn = $b.data('team');
					if (bn in V.cache && V.sortByScore(an, bn) < 0) 
						break;
				}
				if (j < i) {
					var tt = $a.data('team');
					$a.remove().insertBefore($b).data('team',tt);
				}
			}
		}
		V.ranking_animation(1000);
/*		var V = this;
		if(V.refreshing) return false;
		V.refreshing = true;
		var n = Param.judges + 1;
		var l = V.$list;
		var $a, $b, $c, an, bn, ts;
		for (var i = 0; i < Param.teams; i++) {
			$a = $('li:eq(' + i + ')', l);
			an = $a.data('team')
			if (an in V.cache) {
				var ts = (V.cache[an][n]*10).toFixed(1);
				if (Math.abs(ts - $('span.rank-score', $a).html()) > 0.05) {
					$a.find('span.rank-score').html(ts);
					$a.addClass('highlight');
					$a.fadeIn(1000, function(){
						$a.removeClass('highlight').removeClass('hidden');
						V.refreshing = false;
						V.refreshRanking();
					});
					return false;
				}
				for (var j = i-1; j >= 0; j--) {
					$b = $('li:eq(' + j + ')', l);
					bn = $b.data('team');
					if (bn in V.cache) break;
				}
				if (j<0) continue;
				if(V.sortByScore(an, bn) < 0) {
					$a.addClass('highlight');
					$c = $b.clone().data('team', bn).hide().insertAfter($a).slideDown(1000);
					$b.slideUp(1000, function() {
						$a.removeClass('highlight');
						$(this).remove();
						V.refreshing = false;
						V.refreshRanking();
					});
					return false;
				}
			}
		}
		V.refreshing = false;*/
	}
};

$(function() {
	Votes.init();
	var $tabs = $('ul.section_tabs')
	tabi = 1;
	$('li', $tabs).click(function() {
		var teamName = $(this).find('span').html()
		var teamID = $(this).data('team')
		$(this).addClass('selected').siblings().removeClass('selected');
		$('#left_col_team_name').html(teamName).data('team', teamID)
		Votes.currentTeam = teamID;
		Votes.fetch(0);
	})
	$('#current-track').click(function() {
		$('#filter').toggleClass('selected')
	})
	$('#filter-table td').click(function() {
		Votes.vote($(this).data('score'))
	})
	$('#fullscreen').click(function(){
		$('header.cf').slideUp();
		return false;
	})

	setInterval("Votes.fetch()", 15000);
	setInterval("Votes.refreshRanking()", 5000);
});
