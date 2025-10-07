# Role Seeder Documentation

## Overview
The RoleSeeder populates the `auth_groups` table with predefined organizational roles.

## Roles Created

| ID | Role Name | Description |
|----|-----------|-------------|
| 1 | Administrator | System Administrator with full access to all features and settings |
| 2 | Islander | Regular islander with basic access to personal information and common features |
| 3 | Coordinator | Coordinates activities and manages basic operational tasks |
| 4 | Supervisor | Supervises operations and has elevated access to monitoring and reporting |
| 5 | Assistant Manager | Assists in management duties with access to departmental operations |
| 6 | Manager | Manager with comprehensive access to operational management features |
| 7 | Excom | Executive Committee member with strategic access and decision-making authority |
| 8 | Visitor | Temporary visitor with limited access to public information only |

## Usage

### Run the Role Seeder
```bash
php spark db:seed RoleSeeder
```

### Run All Seeders (including roles)
```bash
php spark db:seed DatabaseSeeder
```

## Features

- **Safe Updates**: Updates existing roles instead of duplicating them
- **Foreign Key Safe**: Doesn't truncate tables with foreign key constraints
- **Descriptive Output**: Shows what actions were taken during seeding
- **ID Preservation**: Maintains specific role IDs for consistency

## Files

- **Seeder**: `app/Database/Seeds/RoleSeeder.php`
- **Main Seeder**: `app/Database/Seeds/DatabaseSeeder.php`
- **Target Table**: `auth_groups` in `aislanderapp` database

## Integration

The seeder is integrated with the Role CRUD system and can be accessed via:
- **Web Interface**: http://localhost:8080/roles
- **Menu**: User Management → Roles

## Database Structure

The seeder populates the following fields in `auth_groups`:
- `id`: Unique identifier (1-8)
- `name`: Role name
- `description`: Detailed role description