# AI-Powered Email Template Generator

A Laravel-based API service that generates short, customer-friendly email templates using an AI API.

## Features

- Generate emails based on purpose, recipient name, and tone
- AI-powered email generation
- Modular Controller and Service architecture
- Environment-based API key configuration
- AI response time measurement
- Input validation
- Error handling


## Installation

### Requirements

- PHP 8.1 or higher
- Composer
- Laravel 10
- OpenAI API key

### Setup

1. Clone the repository.
2. Install PHP dependencies:
```bash
composer install
```

3. Create the environment file:
```bash
cp .env.example .env
```

4. Generate the Laravel application key:
```bash
php artisan key:generate
```

5. Add the OpenAI API key to .env:
```bash
OPENAI_API_KEY=your_openai_api_key
OPENAI_REQUEST_TIMEOUT=30
```

6. Clear the configuration cache:
```bash
php artisan config:clear
```

7. Start the Laravel development server:
```bash
php artisan serve
```



## API Usage

### Generate Email

**Endpoint**

`POST /api/generate-email`

**Request Headers**

```text
Accept: application/json
Content-Type: application/json
```

**Request Body**

```json
{
    "purpose": "Request a meeting with a client",
    "recipient_name": "John",
    "tone": "professional"
}
```

**Successful Response**

```json
{
    "success": true,
    "message": "Email generated successfully.",
    "data": {
        "email": "Generated email content",
        "response_time": 1.245
    }
}
```

**Validation Errors**

```text
The API returns HTTP 422 when required fields are missing or invalid.
```

**AI/API Errors**

```json
The API returns HTTP 500 when email generation fails.
```


## AI Usage

The service uses an AI API to generate email content based on the purpose, recipient name, and requested tone.

The AI integration is handled inside `EmailGeneratorService`, keeping AI-related logic separate from the controller.

### Prompt Design

The prompt provides:

- The purpose of the email
- The recipient's name
- The requested tone

The prompt also instructs the AI to:

- Keep the email concise
- Use the requested tone
- Address the recipient by name
- Return only the email body
- Avoid additional explanations or notes

This helps produce consistent, short, and customer-friendly email responses.



## Project Structure

```text
app/
├── Http/
│   └── Controllers/
│       └── EmailController.php
│
└── Services/
    └── EmailGeneratorService.php

routes/
└── api.php

config/
└── openai.php
```

## Architecture

The application follows a simple layered structure:
- EmailController — Handles HTTP requests, validation, and API responses.
- EmailGeneratorService — Handles email generation and AI integration.
- api.php — Defines the API endpoint.
- openai.php — Handles OpenAI configuration using environment variables.

## Environment Variables

The OpenAI API key is stored in the `.env` file and is never hard-coded in the application source code.

```env
OPENAI_API_KEY=your_openai_api_key
OPENAI_REQUEST_TIMEOUT=30
```
The .env file should not be committed to version control.


## Testing

The API can be tested using Postman or any API client.

### Test Endpoint

```text
POST http://127.0.0.1:8000/api/generate-email
```
Use the request body described in the API Usage section.

### Validation Test

To test validation, send a request without recipient_name.
The API should return HTTP 422 with a validation error.