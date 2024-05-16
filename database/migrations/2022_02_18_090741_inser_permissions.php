<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InserPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::table('permissions', function (Blueprint $table) {
            //
            $table->string('group')->default('GENERAL');
        });
        \Illuminate\Support\Facades\DB::table('permissions')->insert([
            ['name' => 'DASHBOARD_VIEW_DASHBOARD', 'description' => 'View dashboard', 'group' => 'Dashboard', 'guard_name' => 'web'],

            ['name' => 'ADMINS_VIEW_LIST', 'description' => 'View list of admins', 'group' => 'Admins', 'guard_name' => 'web'],
            ['name' => 'ADMINS_ADD_ADMIN', 'description' => 'Add new admin', 'group' => 'Admins', 'guard_name' => 'web'],
            ['name' => 'ADMINS_EDIT_ADMIN', 'description' => 'Edit admin', 'group' => 'Admins', 'guard_name' => 'web'],
            ['name' => 'ADMINS_DELETE_ADMIN', 'description' => 'Delete admin', 'group' => 'Admins', 'guard_name' => 'web'],

            ['name' => 'TEAMS_VIEW_LIST', 'description' => 'View list of team members', 'group' => 'Teams', 'guard_name' => 'web'],
            ['name' => 'TEAMS_VIEW_PROFILE', 'description' => 'View profile of team member', 'group' => 'Teams', 'guard_name' => 'web'],
            ['name' => 'TEAMS_ADD_MEMBER', 'description' => 'Add new team member', 'group' => 'Teams', 'guard_name' => 'web'],
            ['name' => 'TEAMS_EDIT_MEMBER', 'description' => 'Edit team member', 'group' => 'Teams', 'guard_name' => 'web'],
            ['name' => 'TEAMS_DELETE_MEMBER', 'description' => 'Delete team member', 'group' => 'Teams', 'guard_name' => 'web'],
            ['name' => 'TEAMS_DEACTIVATE_MEMBER', 'description' => 'Deactivate team member', 'group' => 'Teams', 'guard_name' => 'web'],
            ['name' => 'TEAMS_ACTIVATE_MEMBER', 'description' => 'Activate team member', 'group' => 'Teams', 'guard_name' => 'web'],
            ['name' => 'TEAMS_VIEW_PROJECTS', 'description' => "View project managers' projects", 'group' => 'Teams', 'guard_name' => 'web'],
            ['name' => 'TEAMS_VIEW_ELECTIONS', 'description' => "View [responsible/delegate] elections", 'group' => 'Teams', 'guard_name' => 'web'],

            ['name' => 'ELECTIONS_VIEW_LIST', 'description' => 'View list of elections', 'group' => 'Elections', 'guard_name' => 'web'],
            ['name' => 'ELECTIONS_ADD_ELECTION', 'description' => 'Add new election', 'group' => 'Elections', 'guard_name' => 'web'],
            ['name' => 'ELECTIONS_EDIT_ELECTION', 'description' => 'Edit election', 'group' => 'Elections', 'guard_name' => 'web'],
            ['name' => 'ELECTIONS_DELETE_ELECTION', 'description' => 'Delete election', 'group' => 'Elections', 'guard_name' => 'web'],
            ['name' => 'ELECTIONS_VIEW_ELECTION', 'description' => 'View election', 'group' => 'Elections', 'guard_name' => 'web'],
            ['name' => 'ELECTIONS_RESET_ELECTION', 'description' => 'Reset election', 'group' => 'Elections', 'guard_name' => 'web'],
            ['name' => 'ELECTIONS_ACTIVATE_ELECTION', 'description' => 'Activate election', 'group' => 'Elections', 'guard_name' => 'web'],
            ['name' => 'ELECTIONS_VIEW_CITIZENS', 'description' => "View elections' citizens", 'group' => 'Elections', 'guard_name' => 'web'],
            ['name' => 'ELECTIONS_VIEW_BOXES', 'description' => "View elections' boxes", 'group' => 'Elections', 'guard_name' => 'web'],
            ['name' => 'ELECTIONS_VIEW_PARTIES', 'description' => "View elections' boxes", 'group' => 'Elections', 'guard_name' => 'web'],
            ['name' => 'ELECTIONS_VIEW_CLOSEREQUESTS', 'description' => "View elections' close requests", 'group' => 'Elections', 'guard_name' => 'web'],
            ['name' => 'ELECTIONS_IMPORT_EXCEL', 'description' => "Import citizens excel file", 'group' => 'Elections', 'guard_name' => 'web'],
            ['name' => 'ELECTIONS_LOCALIZE_CITIZEN', 'description' => "Update citizen to local citizen", 'group' => 'Elections', 'guard_name' => 'web'],
            ['name' => 'ELECTIONS_IMMIGRANT_CITIZEN', 'description' => "Update citizen to immigrant citizen", 'group' => 'Elections', 'guard_name' => 'web'],
            ['name' => 'ELECTIONS_ASSIGN_CITIZEN_TO_RESPONSIBLE', 'description' => "Assign citizen inside election to responsible", 'group' => 'Elections', 'guard_name' => 'web'],
            ['name' => 'ELECTIONS_UNASSIGN_CITIZEN_TO_RESPONSIBLE', 'description' => "Unassign citizen inside election to responsible", 'group' => 'Elections', 'guard_name' => 'web'],
            ['name' => 'ELECTIONS_DELETE_CITIZEN', 'description' => 'Delete citizen from election', 'group' => 'Elections', 'guard_name' => 'web'],
            ['name' => 'ELECTIONS_ADD_BOX', 'description' => 'Add new box to election', 'group' => 'Elections', 'guard_name' => 'web'],
            ['name' => 'ELECTIONS_VIEW_BOX', 'description' => 'View box details in election', 'group' => 'Elections', 'guard_name' => 'web'],
            ['name' => 'ELECTIONS_EDIT_BOX', 'description' => 'Edit box in election', 'group' => 'Elections', 'guard_name' => 'web'],
            ['name' => 'ELECTIONS_DELETE_BOX', 'description' => 'Delete box in election', 'group' => 'Elections', 'guard_name' => 'web'],
            ['name' => 'ELECTIONS_RESET_BOX', 'description' => 'Reset box in election', 'group' => 'Elections', 'guard_name' => 'web'],
            ['name' => 'ELECTIONS_ADD_PARTY', 'description' => 'Add new party in election', 'group' => 'Elections', 'guard_name' => 'web'],
            ['name' => 'ELECTIONS_EDIT_PARTY', 'description' => 'Edit party in election', 'group' => 'Elections', 'guard_name' => 'web'],
            ['name' => 'ELECTIONS_DELETE_PARTY', 'description' => 'Delete party in election', 'group' => 'Elections', 'guard_name' => 'web'],
            ['name' => 'ELECTIONS_ADD_CANDIDATE', 'description' => 'Add candidate in election', 'group' => 'Elections', 'guard_name' => 'web'],
            ['name' => 'ELECTIONS_EDIT_CANDIDATE', 'description' => 'Edit candidate in election', 'group' => 'Elections', 'guard_name' => 'web'],
            ['name' => 'ELECTIONS_DELETE_CANDIDATE', 'description' => 'Delete candidate in election', 'group' => 'Elections', 'guard_name' => 'web'],
            ['name' => 'ELECTION_CLOSE_BOX', 'description' => 'Close box', 'group' => 'Elections', 'guard_name' => 'web'],
            ['name' => 'ELECTION_ACTIVATE_BOX', 'description' => 'Activate box', 'group' => 'Elections', 'guard_name' => 'web'],

            ['name' => 'CITIZENS_VIEW_LIST', 'description' => 'View list of citizens', 'group' => 'Citizens', 'guard_name' => 'web'],
            ['name' => 'CITIZENS_ADD_CITIZEN', 'description' => 'Add new citizens', 'group' => 'Citizens', 'guard_name' => 'web'],
            ['name' => 'CITIZENS_EDIT_CITIZEN', 'description' => 'Edit citizens', 'group' => 'Citizens', 'guard_name' => 'web'],
            ['name' => 'CITIZENS_DELETE_CITIZEN', 'description' => 'Delete citizens', 'group' => 'Citizens', 'guard_name' => 'web'],
            ['name' => 'CITIZENS_VIEW_CITIZEN', 'description' => 'View citizens', 'group' => 'Citizens', 'guard_name' => 'web'],
            ['name' => 'CITIZENS_VIEW_PROFILE_DATA', 'description' => "View citizens' profile data", 'group' => 'Citizens', 'guard_name' => 'web'],
            ['name' => 'CITIZENS_VIEW_ELECTIONS', 'description' => "View citizens' elections", 'group' => 'Citizens', 'guard_name' => 'web'],

            ['name' => 'PROJECTS_VIEW_LIST', 'description' => "View projects list", 'group' => 'Projects', 'guard_name' => 'web'],
            ['name' => 'PROJECTS_VIEW_PROJECT', 'description' => "View project", 'group' => 'Projects', 'guard_name' => 'web'],
            ['name' => 'PROJECTS_ADD_PROJECT', 'description' => "View project", 'group' => 'Projects', 'guard_name' => 'web'],
            ['name' => 'PROJECTS_EDIT_PROJECT', 'description' => "Edit project", 'group' => 'Projects', 'guard_name' => 'web'],
            ['name' => 'PROJECTS_DELETE_PROJECT', 'description' => "Delete project", 'group' => 'Projects', 'guard_name' => 'web'],
            ['name' => 'PROJECTS_ADD_TASK', 'description' => "Add task to project", 'group' => 'Projects', 'guard_name' => 'web'],
            ['name' => 'PROJECTS_EDIT_TASK', 'description' => "Edit task in project", 'group' => 'Projects', 'guard_name' => 'web'],
            ['name' => 'PROJECTS_DELETE_TASK', 'description' => "Delete task from project", 'group' => 'Projects', 'guard_name' => 'web'],

            ['name' => 'NOTIFICATIONS_VIEW_LIST', 'description' => "View notifications list", 'group' => 'Notifications', 'guard_name' => 'web'],
            ['name' => 'NOTIFICATIONS_SEND_NOTIFICATION', 'description' => "Send notifications", 'group' => 'Notifications', 'guard_name' => 'web'],

            ['name' => 'SETTINGS_VIEW_SETTINGS', 'description' => "View settings page", 'group' => 'Settings', 'guard_name' => 'web'],
            ['name' => 'SETTINGS_VIEW_STATUSES', 'description' => "View statuses list in settings", 'group' => 'Settings', 'guard_name' => 'web'],
            ['name' => 'SETTINGS_VIEW_PARTIES', 'description' => "View parties list in settings", 'group' => 'Settings', 'guard_name' => 'web'],
            ['name' => 'SETTINGS_VIEW_ANNOUNCEMENTS', 'description' => "View announcements list in settings", 'group' => 'Settings', 'guard_name' => 'web'],
            ['name' => 'SETTINGS_VIEW_PROJECTTYPES', 'description' => "View project types list in settings", 'group' => 'Settings', 'guard_name' => 'web'],
            ['name' => 'SETTINGS_ADD_STATUSES', 'description' => "Add status in settings", 'group' => 'Settings', 'guard_name' => 'web'],
            ['name' => 'SETTINGS_EDIT_STATUSES', 'description' => "Edit status in settings", 'group' => 'Settings', 'guard_name' => 'web'],
            ['name' => 'SETTINGS_DELETE_STATUSES', 'description' => "Delete status in settings", 'group' => 'Settings', 'guard_name' => 'web'],
            ['name' => 'SETTINGS_ADD_PARTIES', 'description' => "Add party in settings", 'group' => 'Settings', 'guard_name' => 'web'],
            ['name' => 'SETTINGS_EDIT_PARTIES', 'description' => "Edit party in settings", 'group' => 'Settings', 'guard_name' => 'web'],
            ['name' => 'SETTINGS_DELETE_PARTIES', 'description' => "Delete party in settings", 'group' => 'Settings', 'guard_name' => 'web'],
            ['name' => 'SETTINGS_ADD_ANNOUNCEMENTS', 'description' => "Add announcement in settings", 'group' => 'Settings', 'guard_name' => 'web'],
            ['name' => 'SETTINGS_EDIT_ANNOUNCEMENTS', 'description' => "Edit announcement in settings", 'group' => 'Settings', 'guard_name' => 'web'],
            ['name' => 'SETTINGS_DELETE_ANNOUNCEMENTS', 'description' => "Delete announcement in settings", 'group' => 'Settings', 'guard_name' => 'web'],
            ['name' => 'SETTINGS_ADD_PROJECTTYPES', 'description' => "Add project type in settings", 'group' => 'Settings', 'guard_name' => 'web'],
            ['name' => 'SETTINGS_EDIT_PROJECTTYPES', 'description' => "Edit project type in settings", 'group' => 'Settings', 'guard_name' => 'web'],

            ['name' => 'ROLES_VIEW_LIST', 'description' => "View list of roles", 'group' => 'Roles', 'guard_name' => 'web'],
            ['name' => 'ROLES_ADD_ROLE', 'description' => "Add new role", 'group' => 'Roles', 'guard_name' => 'web'],
            ['name' => 'ROLES_EDIT_ROLE', 'description' => "Edit role", 'group' => 'Roles', 'guard_name' => 'web'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
