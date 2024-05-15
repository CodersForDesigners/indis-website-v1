
# Requirements
The `interests` field has to have a value when a Person is created because the Indis' CRM system depends on that field having a value in the webhook in order for a lead to be created in their CRM.
Also, the interests in the `interests` field must have the project name prefixed to the interest by a semi-colon, like so,
`PBEL City: Spotlight - D-01`
