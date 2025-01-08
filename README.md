
## index
1. Installation and running locally guide
   - [Prerequisites](#prerequisites)
   - [Installation Steps](#installation-steps)
   - [Frontend Integration](#frontend-integration)
   - [Troubleshooting](#troubleshooting)

2. Mailing System Configuration
   - [Environment Variables](#environment-variables)
   - [Queues setup](#queues-setup)
   - [Running the Queues](#running-the-queues)
   - [Debugging](#debugging)

3. API Reference
   - [Student Environment API Documentation](#student-environment-api-documentation)
     - [Skills Endpoints](#skills-endpoints)
     - [Groups Endpoints](#groups-endpoints)
     - [Profiles Endpoints](#profiles-endpoints)
     - [Endorsements Endpoints](#endorsements-endpoints)
     - [Personal Coach Endpoints](#personal-coach-endpoints)
     - [Feedback Endpoints](#feedback-endpoints)
     - [Additional Endpoints](#additional-endpoints)
   - [Educator Environment API Documentation](#educator-environment-api-documentation)
     - [Skills Endpoints](#skills-endpoints-1)
     - [Groups Endpoints](#groups-endpoints-1)
     - [Students Endpoints](#students-endpoints)
     - [Profiles Endpoints](#profiles-endpoints-1)
     - [Competencies Endpoints](#competencies-endpoints)
     - [Requests Endpoints](#requests-endpoints)
     - [Users Endpoints](#users-endpoints)
   - [General API Documentation](#general-api-documentation)
     - [Notifications Endpoints](#notifications-endpoints)
     - [User Endpoints](#user-endpoints)
     - [Role Endpoints](#role-endpoints)

# Skills Passport

The Skills Passport is a project developed as part of an initiative for the Logistics Management program at Windesheim. This project focuses on tracking and showcasing the skills and progress of students. It provides different views for both students and teachers, allowing them to manage and visualize skills development.

This repository is the backend of the project and it includes the database, APIs and controllers.


## Authors

- [@Mohmmad shabrani](https://www.github.com/Mohmmadshabrani)
- [@David Hoen](https://github.com/davidhoen)

# Installation and running locally guide

This guide will help you set up the Skills Passport backend application and run it locally.

## Prerequisites

- PHP >= 8.2
- Composer
- MySQL/MariaDB # or any other database but then change the `.env` file accordingly [Documention](https://laravel.com/docs/11.x/database)
- Git

## Installation Steps

### 1. Clone the Repository

```bash
git clone https://github.com/Skills-Passport/sp-backend.git
cd sp-backend
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Configure Environment

1. Copy the `.env.example` file and rename it to `.env` either manually or via

```bash
cp .env.example .env
```

2. Configure your database settings in `.env`:
```env
DB_CONNECTION=mysql        # Database driver (MySQL is recommended)
DB_HOST=127.0.0.1          # Database host (localhost)
DB_PORT=3306               # MySQL default port
DB_DATABASE=your_db_name   # Name of your database
DB_USERNAME=your_user      # Database username
DB_PASSWORD=your_password  # Database password
```

3. Set application URLs:
```env
APP_URL=http://localhost:8000      # Backend URL
FRONTEND_URL=http://localhost:3000 # Frontend URL (must match with sp-frontend settings)
```

### 4. Application Setup

1. Generate application key:
```bash
php artisan key:generate
```

2. Run database migrations:
```bash
php artisan migrate
```

3. Seed the database:
```bash
php artisan db:seed
```
> this will including other thing create 4 users
+ student@sp.nl
+ teacher@sp.nl
+ head-teacher@sp.nl
+ admin@sp.nl

With the password for all being: `password`


### 5. Start the Development Server

```bash
php artisan serve
```

The application will be available at `http://localhost:8000`.

## Frontend Integration

For the frontend setup, please refer to the [sp-frontend repository](https://github.com/davidhoen/sp-frontend).

## Troubleshooting

If you encounter any issues:
- Ensure all prerequisites are installed
- Verify database credentials are correct
- Check if ports 8000 and 3000 are available
- Make sure all environment variables are properly set

For more help, please create an issue in the GitHub repository.Here's a clearer way to present the environment variables for the mailing system configuration in Markdown:

# Mailing System Configuration

## Environment Variables

```env
MAIL_MAILER=
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME=
```

### Variable Descriptions

Each variable is essential for setting up your mailing system:

- `MAIL_MAILER`: Specifies the mail driver (e.g., smtp, sendmail)
- `MAIL_HOST`: Your mail server hostname (e.g., smtp.gmail.com)
- `MAIL_PORT`: The port number for your mail server (e.g., 587 for TLS, 465 for SSL)
- `MAIL_USERNAME`: Your email account username or address
- `MAIL_PASSWORD`: Your email account password or app-specific password
- `MAIL_ENCRYPTION`: Type of encryption (e.g., tls, ssl)
- `MAIL_FROM_ADDRESS`: Default sender email address
- `MAIL_FROM_NAME`: Default sender name

Would you like me to add example values for these variables as well?
## Queues setup

The system operates with two dedicated queues:

1. Feedback Queue
2. Endorsement Queue

## Running the Queues

To start processing the queues, use these commands in your terminal:

```bash
# Start the feedback queue
php artisan queue:listen --queue=feedbacks

# Start the endorsement queue
php artisan queue:listen --queue=endorsments
```

## Debugging

If you encounter any issues with the queues, you can check the Laravel log file:

```bash
storage/logs/laravel.log
```

The log file contains detailed information about any errors or unexpected behavior in the queue processing.
## Appendix

Any additional information goes here


## API Reference

# Student Environment API Documentation

## Skills Endpoints

### Get All Skills
```http
GET /api/student/skills
```

**Query Parameters**
| Parameter | Type   | Description            |
|-----------|--------|------------------------|
| with      | string | Include related data (e.g., 'ratings') |
| is_added  | boolean| Filter for added skills only |

### Get Single Skill
```http
GET /api/student/skills/{skill_id}
```

**Query Parameters**
| Parameter | Type   | Description            |
|-----------|--------|------------------------|
| with      | string | Include related data (e.g., 'ratings') |

### Get Skill Feedbacks
```http
GET /api/skills/{skill_id}/feedbacks
```

**Query Parameters**
| Parameter | Type   | Description            |
|-----------|--------|------------------------|
| with      | string | Include related data (e.g., 'skill,createdBy') |

### Get Skill Timeline
```http
GET /api/skills/{skill_id}/timeline
```

**Query Parameters**
| Parameter | Type   | Description            |
|-----------|--------|------------------------|
| per_page  | integer| Number of items per page |

### Add Skill
```http
POST /api/student/skills/{skill_id}/add
```

**Form Parameters**
| Parameter | Type   | Description            |
|-----------|--------|------------------------|
| title     | string | Title of the request   |
| skill     | string | Skill ID              |
| requestee | string | Requestee ID          |

## Groups Endpoints

### Get All Groups
```http
GET /api/groups
```

**Query Parameters**
| Parameter    | Type    | Description            |
|-------------|---------|------------------------|
| with        | string  | Include related data (e.g., 'students,skills') |
| is_archived | boolean | Filter archived status |

### Get My Groups
```http
GET /api/student/groups
```

**Query Parameters**
| Parameter | Type   | Description            |
|-----------|--------|------------------------|
| with      | string | Include related data (e.g., 'students,skills') |

### Get Group Skills
```http
GET /api/student/groups/{group_id}/skills
```

### Join Group
```http
GET /api/student/groups/{group_id}/join
```

### Leave Group
```http
GET /api/student/groups/{group_id}/leave
```

## Profiles Endpoints

### Get All Profiles
```http
GET /api/student/profiles
```

**Query Parameters**
| Parameter | Type   | Description            |
|-----------|--------|------------------------|
| with      | string | Include related data (e.g., 'competencies') |

### Get Single Profile
```http
GET /api/student/profiles/{profile_id}
```

**Query Parameters**
| Parameter | Type   | Description            |
|-----------|--------|------------------------|
| with      | string | Include related data (e.g., 'competencies') |

## Endorsements Endpoints

### Get Recent Endorsements
```http
GET /api/student/endorsements/recent
```

**Query Parameters**
| Parameter   | Type   | Description            |
|-------------|--------|------------------------|
| with        | string | Include related data (e.g., 'skill') |
| competency  | string | Filter by competency ID |

### Request Endorsement
```http
POST /api/student/endorsements/request
```

**Form Parameters**
| Parameter       | Type   | Description            |
|----------------|--------|------------------------|
| title          | string | Title of the request   |
| skill          | string | Skill ID              |
| requestee_email| string | Email of the requestee |

## Personal Coach Endpoints

### Get Teachers
```http
GET /api/student/teachers
```

### Set Personal Coach
```http
PUT /api/student/personal_coach
```

**Form Parameters**
| Parameter         | Type   | Description            |
|------------------|--------|------------------------|
| personal_coach_id| string | ID of the personal coach |

## Feedback Endpoints

### Request Feedback
```http
POST /api/student/feedbacks/request
```

**Form Parameters**
| Parameter | Type   | Description            |
|-----------|--------|------------------------|
| title     | string | Title of the request   |
| skill_id  | string | Skill ID              |
| group_id  | string | Group ID              |
| user_id   | string | User ID               |

## Additional Endpoints

### Get Competencies
```http
GET /api/competencies
```

**Query Parameters**
| Parameter | Type   | Description            |
|-----------|--------|------------------------|
| with      | string | Include related data (e.g., 'skills') |
| count     | boolean| Include count in response |

### Get Requests
```http
GET /api/student/requests
```

**Query Parameters**
| Parameter | Type   | Description            |
|-----------|--------|------------------------|
| with      | string | Include related data (e.g., 'requester,skill,group') |



# Educator Environment API Documentation

## Skills Endpoints

### Get All Skills
```http
GET /api/educator/skills
```

### Get Single Skill
```http
GET /api/educator/skills/{skill_id}
```

### Get Skill Timeline
```http
GET /api/educator/students/{student_id}/{skill_id}/timeline
```

### Create Skill
```http
POST /api/educator/skills/create
```

**Form Parameters**
| Parameter      | Type   | Description            |
|----------------|--------|------------------------|
| title          | string | Skill title           |
| desc           | string | Skill description     |
| competency_id  | string | Associated competency ID |

### Update Skill
```http
PUT /api/educator/skills/{skill_id}
```

**Query Parameters**
| Parameter      | Type   | Description            |
|----------------|--------|------------------------|
| title          | string | New skill title        |
| desc           | string | New description        |
| competency_id  | string | New competency ID      |

### Delete Skill
```http
DELETE /api/educator/skills/{skill_id}
```

## Groups Endpoints

### Create Group
```http
POST /api/educator/groups/create
```

**Form Parameters**
| Parameter    | Type     | Description            |
|-------------|----------|------------------------|
| name        | string   | Group name             |
| desc        | string   | Group description      |
| skills[]    | array    | Array of skill IDs     |
| teachers[]  | array    | Array of teacher IDs   |
| students[]  | array    | Array of student IDs   |

### Get Group Students
```http
GET /api/educator/groups/{group_id}/students
```

**Query Parameters**
| Parameter | Type   | Description            |
|-----------|--------|------------------------|
| with      | string | Include related data (e.g., 'skills') |

### Update Group
```http
PUT /api/educator/groups/{group_id}
```

**Form Parameters**
| Parameter    | Type     | Description            |
|-------------|----------|------------------------|
| name        | string   | New group name         |
| desc        | string   | New description        |
| skills[]    | array    | Updated skill IDs      |
| teachers[]  | array    | Updated teacher IDs    |
| students[]  | array    | Updated student IDs    |

### Delete Group
```http
DELETE /api/educator/groups/{group_id}
```

## Students Endpoints

### Get All Students
```http
GET /api/educator/students
```

**Query Parameters**
| Parameter | Type   | Description            |
|-----------|--------|------------------------|
| with      | string | Include related data (e.g., 'groups') |

### Get Single Student
```http
GET /api/educator/students/{student_id}
```

### Get Student Skill Feedbacks
```http
GET /api/educator/students/{student_id}/skills/{skill_id}/feedbacks
```

### Get Student Recent Endorsements
```http
GET /api/educator/students/{student_id}/endorsements/recent
```

### Get Student Recent Feedbacks
```http
GET /api/educator/students/{student_id}/feedbacks/recent
```

## Profiles Endpoints

### Get All Profiles
```http
GET /api/educator/profiles
```

**Query Parameters**
| Parameter | Type   | Description            |
|-----------|--------|------------------------|
| with      | string | Include related data (e.g., 'competencies') |

### Create Profile
```http
POST /api/educator/profiles/create
```

**Form Parameters**
| Parameter       | Type     | Description            |
|----------------|----------|------------------------|
| title          | string   | Profile title          |
| desc           | string   | Profile description    |
| icon           | string   | Profile icon           |
| color          | string   | Profile color (hex)    |
| competencies[] | array    | Array of competency IDs|

### Update Profile
```http
PUT /api/educator/profiles/{profile_id}
```

### Delete Profile
```http
DELETE /api/educator/profiles/{profile_id}
```

## Competencies Endpoints

### Get All Competencies
```http
GET /api/educator/competencies
```

### Create Competency
```http
POST /api/educator/competencies/create
```

**Form Parameters**
| Parameter    | Type     | Description            |
|-------------|----------|------------------------|
| title       | string   | Competency title       |
| desc        | string   | Description            |
| overview    | string   | Overview text          |
| profiles[]  | array    | Array of profile IDs   |
| skills[]    | array    | Array of skill IDs     |

### Update Competency
```http
PUT /api/educator/competencies/{competency_id}
```

### Delete Competency
```http
DELETE /api/educator/competencies/{competency_id}
```

## Requests Endpoints

### Get Feedback Requests
```http
GET /api/educator/requests/feedbacks
```

**Query Parameters**
| Parameter    | Type    | Description            |
|-------------|---------|------------------------|
| with        | string  | Include related data (e.g., 'group,skill') |
| is_archived | boolean | Filter archived status |

### Get Endorsement Requests
```http
GET /api/educator/requests/endorsements
```

**Query Parameters**
| Parameter    | Type    | Description            |
|-------------|---------|------------------------|
| is_archived | boolean | Filter archived status |
| type        | string  | Request type (e.g., 'review') |

### Get Request Count
```http
GET /api/educator/requests/count
```

## Users Endpoints

### Get Users
```http
GET /api/educator/users
```

**Query Parameters**
| Parameter | Type    | Description            |
|-----------|---------|------------------------|
| roles     | integer | Filter by role ID      |



# General API Documentation

## Notifications Endpoints

### Get All Notifications
```http
GET /api/notifications
```

### Mark Notification as Read
```http
GET /api/notifications/{notification_id}/read
```

## User Endpoints

### Get Current User
```http
GET /api/user
```

**Query Parameters**
| Parameter | Type   | Description            |
|-----------|--------|------------------------|
| with      | string | Include related data (e.g., 'roles,personalCoach') |

## Role Endpoints

### Get All Roles
```http
GET /api/roles
```

### Get Teachers
```http
GET /api/roles
```
Returns role information for teachers in the system.

Each endpoint returns data in JSON format and requires appropriate authentication headers.