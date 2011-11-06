var Param = {
	"teams" : 10,
	"judges" : 5
};
var Votes = {
	"init" : function() {
		this.cache = {};
		this.currentTeam = 1;

		this.$chart = $('#spaces_section div.left_col');
		this.$list = $('#spaces_section div.rank-list ul');
		$('li', this.$list).hide();

		this.fetch();
	},
	"fetch" : function() {
		var V = this;
		var id=V.currentTeam
		$.ajax({
			type : "get",
			data : 'id=' + id,
			url : 'fetch-score.php',
			cache : false,
			dataType : 'json',
			success : function(data) {
				if(data.success != true) {
					return false
				}
				V.cache[0] = [0].concat([1,2,1,2,3,4,5,6,77,87,1,2,1,2,3,4,5,6,77,87,1,2,1,2,3,4,5,6,77,87,1,2,1,2,3,4,5,6,77,87]); // V.cache[0] = [0].concat(data.total);
				V.cache[id] = data.score;
				return true;
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
	"refreshChart" : function() {
		var V = this;
		var id = V.currentTeam;
		var scores = V.cache[id];
		var total = V.cache[0][id];
		$('div.agenda-item', V.$chart).each(function(i) {
			$(this).animate({
				width : Math.max(scores[i] * 40 - 7, 33)
			});
		});
		$('#info-balloon').animate({
			left : 157 + total / 100 * (340 - 157)
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
	"refreshRanking" : function() {
		V=this;
		var l = $('#spaces_section div.rank-list ul');
		for (var i = 0; i < Param.teams; i++) {
			var a = $('li:eq(' + i + ')', l);
			var ai = parseInt(a.data('team'))
			var va = V.cache[0][ai];
			var b = a
			var bj = ai
			var vb = va
			if (va > 0) a.fadeIn();
			for( j = 0; j < i; j++) {
				b = $('li:eq(' + j + ')', l);
				bj = parseInt(b.data('team'));
				vb = V.cache[0][bj];
				if(va > vb) break;
			}
			if(j < i) {
				a.slideUp(function() {
					$(this).remove().insertBefore(b).slideDown(function() {
					});
				})
				return true;
			}
		}
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
		Votes.fetch()
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
	setTimeout(Votes.fetch(), 5000);
	setTimeout(Votes.refreshChart(), 1000);
	setTimeout(Votes.refreshRanking(), 2000);
});