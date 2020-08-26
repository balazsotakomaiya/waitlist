# Waitlist

## Position algorithm
1. Order all emails by CREATED_AT  
1.1 Newest email would mean the lowest position
2. Retrieve the amount of referrals an email has made
3. Deduct (number of emails * 10) from current position based on date

