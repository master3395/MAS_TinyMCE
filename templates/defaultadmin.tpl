

<div class="pagecontainer">

	{if isset($show_sync_version) and $show_sync_version}
	<p class="pagewarning" style="margin-bottom: 0.5em;">
		{$mod->Lang('database_version_newer_help')}
		<a href="{cms_action_url action='sync_version'}">{$mod->Lang('sync_version_to_files')}</a>
	</p>
	{/if}

	<div class="pageoverflow" style="margin-bottom: 1em;">
		{$admin_section_formstart}
		<p class="pagetext">{$admin_section_label}:</p>
		<p class="pageinput">{$admin_section_dropdown}<br/><span class="information">{$admin_section_help}</span></p>
		<p class="pageinput">{$admin_section_submit}</p>
		{$admin_section_formend}
	</div>

	<a href="{cms_action_url action='admin_editprofile'}">
		{admin_icon icon='newobject.gif'}&nbsp;{$mod->Lang('new_profile')}
	</a>

	{include file='module_file_tpl:TinyMCE;admin_profileslist.tpl' scope='root'}



</div>
