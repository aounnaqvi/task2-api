Dynamic Form Creation & Submission Mechanism

- Send a JSON POST Request to create-form.php in the format: 
{
  "fields": [
    {
      "FieldType": "input",
      "FieldName": "FirstName",
      "validationRule": "required"
    }
  ],
  "email" : "emailToSendFormTo@gmail.com"
}

- You can check the submitted forms at /get_forms.php and naviagate to one of the submitted form.

- That generated form can be used to submit entries to given email in API request.

- Make sure to create the database from the given .sql file to make code work. 
