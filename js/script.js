var Param = {
	"teams" : 10,
	"judges" : 5
};
var Votes = {
	"init" : function() {
		this.cache = {};
        this.rank = [];
        this.once = true;
			
		this.currentTeam = 1;

		this.$chart = $('#spaces_section div.left_col');
		this.$list = $('#spaces_section div.rank-list ul');

		this.fetch(0);
	},
    "ready": function() {
    	// TODO show the ranking directly since this is the first time
    },
	"fetch" : function(id) {
		var V = this;
//		id = id | V.currentTeam
		$.ajax({
			type : "get",
			data : 'id=' + id,
			url : 'fetch-score.php',
			cache : false,
			dataType : 'json',
			success : function(data) {
				if(data.success != true)
                    return false;
//                if(id == 0) {
                for (id in data.scores)
                    V.write(id, data.scores[id]);
                if (V.once) {
                	V.once = false;
                	V.ready();
                }
                V.refreshChart();
                return true;
//                }
//                V.write(id, data.score);
//                if(id == V.currentTeam)
//                    V.refreshChart();

//				V.cache[0] = [0].concat([1,2,1,2,3,4,5,6,77,87,1,2,1,2,3,4,5,6,77,87,1,2,1,2,3,4,5,6,77,87,1,2,1,2,3,4,5,6,77,87]); // V.cache[0] = [0].concat(data.total);
//				V.cache[id] = data.score;
			},
            error: function() {
                V.fetch(id);
            }
		});
	},
    "write": function(id, score) {
        var s = score.slice(0,Param.judges);
        var sum = 0;
        for (var i =0; i < Param.judges; i++) sum += score[i];
        s.push(score[15]);
        s.push((sum / Param.judges + score[15]) / 2);
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
					return;
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
		var scores = V.cache[V.currentTeam];
//		if (scores) { for (var i = 0; i < n + 2; i++) scores[i] = 0; }
		var total = scores[n+1] * 100;
		$('div.agenda-item', V.$chart).each(function(i) {
			$(this).animate({ width : Math.max(scores[i] * 40 - 7, 33) });
		});
		$('#info-balloon').animate({ left : 157 + total / 100 * (340 - 157) })
		var rand = $('#info-balloon>h4').html() * 1.0;
		( inloop = function() {
			if(rand > total) $('#info-balloon>h4').html((rand -= 1.1).toFixed(1));
			else $('#info-balloon>h4').html((rand += 1.1).toFixed(1));
			if(Math.abs(rand - total) < 2) {
				$('#info-balloon>h4').html(total.toFixed(1));
				return 0;
			}
			setTimeout(inloop, 20);
		})();
	},
    "refreshRanking": function() {
        var V = this;
        var rank = [];
        var $li;
        var idx;
        for (var team in V.cache)
            rank.push(team);
        var len = rank.length;
        rank.sort(V.sortByScore);
        for (var i = 0; i++ < len; ) {
            team = rank[i];
            if(V.rank.len <= i) {
                V.rank.push(team);
                $li = $('li:eq(' + i + ')', V.$list);
                $('.rank-list-' + team, V.$list).insertBefore($li).slideDown()
                    .find('span.rank-score').html(V.cache[team][Param.judges + 1]);
            } else if(team != V.rank[i]) {
                idx = V.rank.indexOf(team);
                if(idx >= 0) {
                    V.rank.splice(idx, 1);
                    $('.rank-list-' + team, V.$list).slideUp();
                }
                V.rank.splice(i, 0, team);
                $li = $('li:eq(' + i + ')', V.$list);
                $('.rank-list-' + team, V.$list).insertBefore($li).slideDown()
                    .find('span.rank-score').html(V.cache[team][Param.judges + 1]);
            } else if(team == V.rank[i]) {
                $('.rank-list-' + team, V.$list)
                    .find('span.rank-score').html(V.cache[team][Param.judges + 1]);
            }
        }
    },
    "sortByScore": function(a,b) {
        var pos = Param.judges + 1;
        if(this.cache[a][pos] < this.cache[b][pos])
            return -1;
        else if(this.cache[a][pos] > this.cache[b][pos])
            return 1;
        else if(this.cache[a][pos - 1] < this.cache[b][pos - 1])
            return 1;
        else if(this.cache[a][pos - 1] > this.cache[b][pos - 1])
            return -1;
        else
            return 0;
    },
//	"refreshRanking" : function() {
//		var V = this;
//		var l = $('#spaces_section div.rank-list ul');
//		for (var i = 0; i < Param.teams; i++) {
//			var a = $('li:eq(' + i + ')', l);
//			var ai = parseInt(a.data('team'))
//			var va = V.cache[0][ai];
//			var b = a
//			var bj = ai
//			var vb = va
//			if (va > 0) {
//				
//				a.fadeIn();
//			}
//			for( j = 0; j < i; j++) {
//				b = $('li:eq(' + j + ')', l);
//				bj = parseInt(b.data('team'));
//				vb = V.cache[0][bj];
//				if(va > vb) break;
//			}
//			if(j < i) {
//				a.slideUp(function() {
//					$(this).remove().insertBefore(b).slideDown(function() {
//					});
//				})
//				return true;
//			}
//		}
//		return false;
//	}
};

$(function() {
	Votes.init();
	var tabs = $('ul.section_tabs')
	tabi = 0;
	$('.arrow.left').click(function() {
		if(tabi > 0) {
			tabi -= 1;
			tabs.animate({ top : '+=50'})
		}
	})
	$('.arrow.right').click(function() {
		if(tabi < Param.teams / 5 - 1) {
			tabi += 1;
			tabs.animate({ top : '-=50' })
		}
	})
	tabs.find('li').click(function() {
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
		$('#filter').removeClass('selected')
		Votes.vote($(this).data('score'))
	})
	setInterval(Votes.fetch(0), 2000);
	setInterval(Votes.refreshRanking(), 1000);
});
