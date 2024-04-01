<?php


/**
 * Content
 * 
 * This class houses some details of markups that neeeds to be reusable, for insttance the fields in an input fields ...
 */
class Content
{
    /**
     * choose
     *
     * @return array
     * This method is responsible for the content why choose us section of the index page 
     */
    public function choose(): array
    {
        return [
            [
                "title" => "Security",
                "icon" => "fa-solid fa-shield",
                "content" => "We offer you a secured voting experience where no one will be able to tamper with your votes and no one will know whom you voted for."
            ],
            [
                "title" => "Reliability",
                "icon" => "fas fa-handshake",
                "content" => "We offer you a secured voting experience where no one will be able to tamper with your votes and no one will know whom you voted for."
            ],
            [
                "title" => "Swiftness",
                "icon" => "fas fa-fighter-jet",
                "content" => "We offer you a fast application where by you will be receving election update on the go."
            ]
        ];
    }
    /**
     * loginFields
     *
     * @return array
     * This methods is reponsible for the details of the login form fields 
     */
    public function loginFields(): array
    {
        return [
            [
                "type" => "text",
                "name" => "username",
                "label" => "Username"
            ],
            [
                "type" => "password",
                "name" => "password",
                "label" => "Password"
            ]
        ];
    }

    public function passwordReset(): array
    {
        return [
            [
                "type" => "password",
                "name" => "old_password",
                "label" => "Old Password"
            ],
            [
                "type" => "password",
                "name" => "password",
                "label" => "New Password"
            ],  [
                "type" => "password",
                "name" => "confirm_password",
                "label" => "Confirm Password"
            ]
        ];
    }
    public function resetPin(): array
    {
        return [
            [
                "type" => "password",
                "name" => "password",
                "label" => "Acount Password"
            ],
            [
                "type" => "password",
                "name" => "voting_pin",
                "label" => "Pin"
            ]
        ];
    }

    public function registerFields(): array
    {
        return [
            [
                "type" => "text",
                "name" => "firstname",
                "label" => "First Name"
            ],
            [
                "type" => "text",
                "name" => "lastname",
                "label" => "Last Name"
            ],
            [
                "type" => "text",
                "name" => "middlename",
                "label" => "Middle Name"
            ],
            [
                "type" => "email",
                "name" => "email",
                "label" => "Email"
            ],
            [
                "type" => "text",
                "name" => "username",
                "label" => "Username"
            ],
            [
                "type" => "password",
                "name" => "password",
                "label" => "Password"
            ],
            [
                "type" => "password",
                "name" => "confirm_password",
                "label" => "Confirm Password"
            ],
        ];
    }


    public function electionFields()
    {
        return [
            [
                "type" => "text",
                "name" => "election_name",
                "label" => "Election Name",
            ],
            [
                "type" => "date",
                "name" => "election_start_date",
                "label" => "Election Start date",
            ],
            [
                "type" => "date",
                "name" => "election_end_date",
                "label" => "Election end date",
            ],
        ];
    }

    public function teams()
    {
        return [
            [
                "img" => "me.jpg",
                "link_w" => "#",
                "link_t" => "#",
                "link_f" => "#",
                "name" => "Abdul-Azeez Abdul-Azeem",
                "role" => "Lead Developer",
            ],
        ];
    }
}
