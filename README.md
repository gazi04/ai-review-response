# AI Review Respond

AI Review Respond is a powerful Shopware 6.7 plugin designed to streamline the process of responding to customer reviews. By leveraging Large Language Models (LLMs), it provides shop managers with professionally drafted responses tailored to the customer's feedback and rating.

## Features

- **One-Click Drafting**: Adds a "Draft with AI" button directly to the Review Detail page in the Administration.
- **Context-Aware Responses**: Generates replies based on the specific review content and the star rating provided.
- **Flexible AI Integration**: Supports various AI endpoints, including OpenAI and GitHub Models.
- **Modern UI**: Fully integrated into the Shopware Administration using the Meteor UI component library.

## Installation

### 1. Install via Composer (Recommended)

Since this plugin requires external PHP libraries, it is best installed via Composer from your Shopware project root:

```bash
composer require ai-review-respond/ai-review-respond
```

*Note: If you are using DDEV, use `ddev composer require ai-review-respond/ai-review-respond`.*

### 2. Activate the Plugin

Run the following commands to install and activate the plugin:

```bash
bin/console plugin:install --activate AiReviewRespond
bin/console cache:clear
```

### 3. Rebuild the Administration

To ensure the "Draft with AI" button appears in the administration, rebuild the assets:

```bash
bin/build-administration.sh
```

## Configuration

After installation, navigate to **Settings > Extensions > Ai Review Respond** in your Shopware Administration.

| Setting | Description | Default |
| :--- | :--- | :--- |
| **Inference Endpoint** | The base URL for the AI API. | `https://models.github.ai/inference` |
| **Model Name** | The specific LLM model to use. | `openai/gpt-4.1` |
| **Token / API Key** | Your secret API Key (required). | *None* |

## How to Use

1. Go to **Content > Reviews**.
2. Open a specific review to see its details.
3. Locate the **"Draft with AI"** button in the review comment section.
4. Click the button to automatically generate a draft response in the comment field.
5. Review, edit if necessary, and save.

## Technical Details

- **Backend**: Symfony-based controller and service layer in PHP 8.2+.
- **Frontend**: Vue.js component extension with Meteor UI integration.
- **Dependencies**: `openai-php/client` for API communication.
- **Security**: API keys are securely stored using Shopware's `SystemConfigService`.

## License

This project is licensed under the MIT License.
