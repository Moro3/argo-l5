<?php

/*
 * This is a simple example of the main features.
 * For full list see documentation.
 */

// Create admin model from User class with title and url alias
Admin::model('\User')->title('Users')->as('users-alias-name')->denyCreating(function ()
{
	// Deny creating on thursday
	return date('w') == 4;
})->denyEditingAndDeleting(function ($instance)
{
	// deny editing and deleting rows when this is true
	return ($instance->id <= 2) || ($instance->email == 'admin');
})->columns(function ()
{
	// Describing columns for table view
	Column::string('name', 'Name');
	Column::string('email', 'Email');
})->form(function ()
{
	// Describing elements in create and editing forms
	FormItem::text('name', 'Name');
	FormItem::text('email', 'Email');
});


Admin::model('App\Contact2')->title('Contact')->alias('contacts2')->display(function ()
{
    $display = AdminDisplay::table();
    $display->with('country', 'companies');
    $display->filters([
        Filter::related('country_id')->model('App\Country'),
    ]);
    $display->columns([
        Column::image('photo')->label('Photo'),
        Column::string('fullName')->label('Name'),
        Column::datetime('birthday')->label('Birthday')->format('d.m.Y'),
        Column::string('country.title')->label('Country')->append(Column::filter('country_id')),
        Column::lists('companies.title')->label('Companies'),
    ]);
    return $display;
}