<?php

namespace Corals\Modules\FormBuilder\Classes;

use Ctct\Components\Contacts\Contact;
use Ctct\ConstantContact as ConstantContactLib;
use Ctct\Exceptions\CtctException;

class ConstantContact
{
    /**
     * Subscribe user
     *
     * @param $email
     * @param $name
     * @return bool
     */
    public static function subscribe($email, $name, $list_id)
    {
        try {
            $api_key = \Settings::get('form_builder_constant_contact_api_key');
            $api_secret = \Settings::get('form_builder_constant_contact_api_secret');


            $cc = new ConstantContactLib($api_key);

            // check to see if a contact with the email address already exists in the account
            $response = $cc->contactService->getContacts($api_secret, ["email" => $email]);
            // create a new contact if one does not exist
            if (empty($response->results)) {
                $action = "Creating Contact";
                $contact = new Contact();
                $contact->addEmail($email);
                $contact->addList($list_id);
                $contact->first_name = $name;
                /*
                 * The third parameter of addContact defaults to false, but if this were set to true it would tell Constant
                 * Contact that this action is being performed by the contact themselves, and gives the ability to
                 * opt contacts back in and trigger Welcome/Change-of-interest emails.
                 *
                 * See: http://developer.constantcontact.com/docs/contacts-api/contacts-index.html#opt_in
                 */
                $returnContact = $cc->contactService->addContact($api_secret, $contact, 'ACTION_BY_OWNER');
                // update the existing contact if address already existed
            } else {
                $action = "Updating Contact";
                $contact = $response->results[0];
                if ($contact instanceof Contact) {
                    $contact->addList($list_id);
                    $contact->first_name = $name;
                    /*
                     * The third parameter of updateContact defaults to false, but if this were set to true it would tell
                     * Constant Contact that this action is being performed by the contact themselves, and gives the ability to
                     * opt contacts back in and trigger Welcome/Change-of-interest emails.
                     *
                     * See: http://developer.constantcontact.com/docs/contacts-api/contacts-index.html#opt_in
                     */
                    $returnContact = $cc->contactService->updateContact($api_secret, $contact, 'ACTION_BY_OWNER');
                }
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        } // catch any exceptions thrown during the process and print the errors to screen
    }

    /**
     * Returns list of subscribers lists of account
     *
     * @return array
     * @throws \Exception
     */
    public static function lists()
    {
        try {
            $api_key = \Settings::get('form_builder_constant_contact_api_key');
            $api_secret = \Settings::get('form_builder_constant_contact_api_secret');

            $cc = new ConstantContactLib($api_key);

            $lists = $cc->listService->getLists($api_secret);


            $list_array = [];
            foreach ($lists as $list_item) {
                $list_array[$list_item->id] = $list_item->name;
            }

            return $list_array;
        } catch (CtctException $exception) {
            $error_message = "";
            foreach ($exception->getErrors() as $error) {
                $error_message .= $error->error_message . '<br> <a target="_blank" style="color:black" href="http://developer.constantcontact.com/api-keys.html">http://developer.constantcontact.com/api-keys.html</a>';
            }
            echo '<label  class="label label-danger text-center pull-left p-t-5 p-b-5" style="width: 100%">' . $error_message . '</label> ';
            log_exception($exception, 'MailChimpGetLists', 'subscribe');
        }
    }
}
