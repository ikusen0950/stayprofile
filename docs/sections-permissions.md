# Sections Permissions Setup

## Created Permissions
The following permissions have been created for the sections module:

1. **sections.view** - View sections
2. **sections.create** - Create sections  
3. **sections.edit** - Edit sections
4. **sections.delete** - Delete sections

## Permission Assignment
- All sections permissions have been automatically assigned to the **admin** role
- These permissions follow the same pattern as departments permissions

## Usage in Code
The permissions are used throughout the sections module:

### Controller Level (SectionsController.php)
- `has_permission('sections.view')` - Controls access to index and show methods
- `has_permission('sections.create')` - Controls access to store method
- `has_permission('sections.edit')` - Controls access to update method
- `has_permission('sections.delete')` - Controls access to delete method

### View Level (sections/index.php)
- `$permissions['canCreate']` - Shows/hides create button
- `$permissions['canView']` - Shows/hides view action buttons
- `$permissions['canEdit']` - Shows/hides edit action buttons
- `$permissions['canDelete']` - Shows/hides delete action buttons

### Sidebar Menu (layout/sidebar.php)
- `has_permission('sections.view')` - Shows/hides sections menu item

## Seeder Information
- Seeder file: `app/Database/Seeds/SectionsPermissionsSeeder.php`
- Run with: `php spark db:seed SectionsPermissionsSeeder`
- The seeder automatically checks for existing permissions and roles before creating/assigning

## Testing
All sections permissions have been verified to work correctly:
- ✅ Permissions created in database
- ✅ Permissions assigned to admin role
- ✅ Controller permission checks working
- ✅ View permission checks working
- ✅ Menu access control working