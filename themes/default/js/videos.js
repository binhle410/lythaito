/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 1 - 31 - 2010 5 : 12
 */

function sendrating(id, point, newscheckss) {
	if (point == 1 || point == 2 || point == 3 || point == 4 || point == 5) {
		$.post(nv_base_siteurl + 'index.php?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=rating&nocache=' + new Date().getTime(), 'id=' + id + '&checkss=' + newscheckss + '&point=' + point, function(res) {
			$('#stringrating').html(res);
		});
	}
}

function nv_del_content(id, checkss, base_adminurl, detail) {
	if (confirm(nv_is_del_confirm[0])) {
		$.post(base_adminurl + 'index.php?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=del_content&nocache=' + new Date().getTime(), 'id=' + id + '&checkss=' + checkss, function(res) {
			var r_split = res.split('_');
			if (r_split[0] == 'OK') {
				if( detail ){
					window.location.href = r_split[2];
				}
				else
				{
					window.location.href = strHref;
				}
			} else if (r_split[0] == 'ERR') {
				alert(r_split[1]);
			} else {
				alert(nv_is_del_confirm[2]);
			}
		});
	}
	return false;
}

function get_alias( op ) {
	var title = strip_tags(document.getElementById('idtitle').value);
	if (title != '') {
		$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=' + op + '&nocache=' + new Date().getTime(), 'get_alias=' + encodeURIComponent(title), function(res) {
			if (res != "") {
				document.getElementById('idalias').value = res;
			} else {
				document.getElementById('idalias').value = '';
			}
		});
	}
	return false;
}

function get_duration( op ) {
	var path = strip_tags(document.getElementById('vid_path').value);
	if (path != '') {
		$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=' + op + '&nocache=' + new Date().getTime(), 'get_duration=' + path, function(res) {
			if (res != "") {
				document.getElementById('vid_duration').value = res;
			} else {
				document.getElementById('vid_duration').value = '';
			}
		});
	}
	return false;
}


$(window).load(function(){
	var newsW = $('#news-bodyhtml').innerWidth();
	$.each($('#news-bodyhtml img'), function(){
		var w = $(this).innerWidth();
		var h = $(this).innerHeight();
		
		if( w > newsW ){
			$(this).prop('width', newsW);
			$(this).prop('height', h * newsW / w);
		}
	});
});


function nv_del_playlist_list(oForm, playlist_id, fcheck) {
	var del_list = '';
	var fa = oForm['idcheck[]'];
	if (fa.length) {
		for (var i = 0; i < fa.length; i++) {
			if (fa[i].checked) {
				del_list = del_list + ',' + fa[i].value;
			}
		}
	} else {
		if (fa.checked) {
			del_list = del_list + ',' + fa.value;
		}
	}

	if (del_list != '') {
		if (confirm(nv_is_del_confirm[0])) {
			$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=user-playlist&nocache=' + new Date().getTime(), 'del_list=' + del_list + '&fcheck=' + fcheck + '&ajax=1&playlist_id=' + playlist_id, function(res) {
				nv_change_playlist_result(res, fcheck);
			});
		}
	}
}

function nv_change_playlist_cat(playlist_id, mod, fcheck) {
	var nv_timer = nv_settimeout_disable('id_' + mod + '_' + playlist_id, 1500);
	var new_vid = $('#id_' + mod + '_' + playlist_id).val();
	$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=user-playlist&nocache=' + new Date().getTime(), 'playlist_id=' + playlist_id + '&fcheck=' + fcheck + '&ajax=2&mod=' + mod + '&new_vid=' + new_vid, function(res) {
		var r_split = res.split('_');
		if (r_split[0] != 'OK') {
			alert(nv_is_change_act_confirm[2]);
		}
		clearTimeout(nv_timer);
		nv_show_list_playlist_cat('playlist_cat', fcheck);
	});
	return;
}

function nv_del_playlist_cat(playlist_id, fcheck) {
	if (confirm(nv_is_del_confirm[0])) {
		$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=user-playlist&nocache=' + new Date().getTime(), '&ajax=4&playlist_id=' + playlist_id + '&fcheck=' + fcheck, function(res) {
			var r_split = res.split('_');
			if (r_split[0] == 'OK') {
				nv_show_list_playlist_cat('playlist_cat', fcheck);
			} else if (r_split[0] == 'ERR') {
				alert(r_split[1]);
			} else {
				alert(nv_is_del_confirm[2]);
			}
		});
	}
	return false;
}

function nv_change_playlist(playlist_id, id, mod, fcheck) {
	if (mod == 'delete' && !confirm(nv_is_del_confirm[0])) {
		return false;
	}
	var new_vid = $('#id_playlist_sort_' + id).val();
	$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=user-playlist&nocache=' + new Date().getTime(), 'id=' + id + '&playlist_id=' + playlist_id + '&ajax=1&mod=' + mod + '&fcheck=' + fcheck + '&new_vid=' + new_vid, function(res) {
		nv_change_playlist_result(res, fcheck);
	});
	return;
}

function nv_change_playlist_result(res, fcheck) {
	var r_split = res.split('_');
	if (r_split[0] != 'OK') {
		alert(nv_is_change_act_confirm[2]);
	}
	var playlist_id = parseInt(r_split[1]);
	nv_show_list_playlist(playlist_id, 'playlist', fcheck);
	return;
}

function nv_show_list_playlist(playlist_id, mod_list, fcheck) {
	if (document.getElementById('module_show_list')) {
		$('#module_show_list').load(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=v_funcs&playlist_id=' + playlist_id + '&mod_list=' + mod_list + '&fcheck=' + fcheck + '&nocache=' + new Date().getTime());
	}
	return;
}

function nv_show_list_playlist_cat( mod_list, fcheck ) {
	if (document.getElementById('module_show_playlist')) {
		$('#module_show_playlist').load(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=v_funcs&mod_list=' + mod_list + '&fcheck=' + fcheck + '&nocache=' + new Date().getTime());
	}
	return;
}

function nv_add_user_playlist(id, user_playlist, mod, fcheck) {
	if (mod != 'add_user_playlist') {
		return false;
	}
	$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=user-playlist&nocache=' + new Date().getTime(), 'id=' + id + '&playlist_id=' + user_playlist + '&ajax=3&mod=' + mod + '&fcheck=' + fcheck, function(res) {
		alert(res);
	});
	return;
}

function nv_show_user_playlist( mod_list, fcheck ) {
	var id =  $('#add_to_userlist').attr('value');
	if (document.getElementById('add_to_userlist')) {
		$('#add_to_userlist').load(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=v_funcs&mod_list=' + mod_list + '&id=' + id + '&fcheck=' + fcheck + '&nocache=' + new Date().getTime() );
	}
	return;
}

function nv_favourite_videos( id, type, newscheckss, fcheck ) {
	if (type != 'fav') {
		return false;
	}
	$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=v_funcs&nocache=' + new Date().getTime(), 'id=' + id + '&mod_list=' + type + '&newscheckss=' + newscheckss + '&fcheck=' + fcheck, function(res) {
		var r_split = res.split('_');
		if (r_split[0] == 'OK') {
			var vid = r_split[2];
			var check_session = r_split[3];
			alert(r_split[1]);
			if (document.getElementById('favourite-' + vid)) {
				$('#favourite-' + vid).load(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=v_funcs&mod_list=get_fav' + '&id=' + vid + '&fcheck=' + check_session + '&nocache=' + new Date().getTime());
			}
		}
	});
	return;
}

function nv_colapse_favourites( ){
	$("#add_to_userlist").collapse('hide');
}

function nv_report_videos( id, newscheckss ) {
	var rid = $("#report_videos input:radio[name ='report_videos']:checked").val();
	if ( rid > 0){
		$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=v_funcs&nocache=' + new Date().getTime(), 'id=' + id + '&rid=' + rid + '&mod_list=report' + '&newscheckss=' + newscheckss, function(res) {
			var r_split = res.split('_');
			if (r_split[0] == 'OK') {
				var vid = r_split[2];
				var check_session = r_split[3];
				alert(r_split[1]);
				$("#report_videos input:radio[name ='report_videos']:checked").prop('checked', false);
				nv_colapse_report();
			}
		});
	}else{
		alert(report_non_check);
	}
	return;
}

function nv_colapse_report( ){
	$("#report_videos").collapse('hide');
}
