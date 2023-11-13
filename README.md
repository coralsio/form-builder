# Corals Form Builder

- Laraship FormBuilder is a multi-step Drag & Drop Form creator where you can select fields among 14 different types, then embed the form either on Laraship CMS, or any other external web page, there are many options for customizations form controls like validation, styling, labels.

<p><img src="https://www.laraship.com/wp-content/uploads/2018/10/laraship-multistep-formbuilder.png" alt=""></p>


- In FormBuilder Permissions you can specify whether this user can access all forms created by different users or any forms created by him.


- You can also specify permissions to actions available on the form completions.


- You can define unlimited actions on form submissions of one the following types :

  1.Saving to the database.

  2.Call an API.

  3.Send an Email

  4.Aweber Autoresponder

  5.Mailchimp auto responder

  6.Constant contact auto responder

  7.Get Response auto responder.

  8.Covert Comission auto responder.


- Also, you can specify whether to display a message to a user or redirect him to another page.


- One of the special features is responsive embedding, which is a very common issue on other forums where you cannot control the height of the form, with Laraship Form builder it detected the height of the form automatically and resize the iframe based on.


- its recommended to use the shortcode for internal embedding, it can be found the forms listing.


- for external embedding, you can use the script that is located inside form designer.

<p><img src="https://www.laraship.com/wp-content/uploads/2018/10/form_embed.png" alt=""></p>


- Submissions for each form can be viewed from Form Menu, you can select which fields to show on the listing and which on the details page.

<p><img src="https://www.laraship.com/wp-content/uploads/2018/10/laraship-formbuilder-submission-list.png" alt=""></p>
<p><img src="https://www.laraship.com/wp-content/uploads/2018/10/laraship-formbuilder-submission-details.png" alt=""></p>

- Under Form Settings, You can specify API access details for each autoresponder.

<p><img src="https://www.laraship.com/wp-content/uploads/2018/10/laraship-formbuilder-autoresponder-settings.png" alt=""></p>

- Also, you can define which fields to be shown in the submission listing table, by checking the “show on listing flag” on the question definition builder.

<p><img src="https://www.laraship.com/wp-content/uploads/2018/10/laraship-form-builder-selection.png" alt=""></p>

- The form can be also configured with Recaptcha

## Installation

You can install the package via composer:

```bash
composer require corals/form-builder
```
## Hire Us
Looking for a professional team to build your success and start driving your business forward.
Laraship team ready to start with you [Hire Us](https://www.laraship.com/contact)

## Demo
You can see Form Bulder Demo by following this link https://formbuilder.laraship.com/

## Testing

```bash
vendor/bin/phpunit vendor/corals/form-builder/tests 
```
