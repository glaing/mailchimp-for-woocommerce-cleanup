# mailchimp-for-woocommerce-cleanup
This tool has been created to resolve an issue were all customers were imported as MailChimp Subscribers from my WooCommerce Store. This led to fairly low read and interaction rates on my email campaigns. More concerning though, was that I had a fairly high unsubscribe rate, with the reason 'I didn't sign up for this list', which I fear will have damaged my store's reputation with some of my customers.

It searches for orders where the customer has not opted in to be a MailChimp subscriber. These customers were previously being imported by the MailChimp for WooCommerce Plugin from MailChimp.

Please check through the data carefully before importing the unsubscribe list into MailChimp to prevent users being accidently unsubscribed.

Note: This tool cannot check to see if users have signed up to the MailChimp using any other method than the Subscribe option on your checkout page. If a customer has joined your mailing list through another method, but then not opted in during checkout, they will be removed.

To use this, download as a zip and import as a plugin in WordPress.

Once activated, it can be accessed through Tools -> MailChimp Cleanup in the Wordpress Adminstration Area.

I built this for my site, but I have added it here as it may be useful for other WooCommerce Store Owners. 
