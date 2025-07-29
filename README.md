# 🌱 GreenAudit - Web application for calculating and monitoring energy consumption

GreenAudit is a web application designed to calculate and monitor energy consumption while educating users to adopt a more sustainable lifestyle.
# Key Features
1. Energy Consumption Calculation
Purpose: Allows users to input household appliances and usage details to calculate:
- Energy consumption
- Estimated cost based on real Romanian energy tariffs
- A classification of consumption:
  - Optimal
  - Moderate
  - Wasteful
## Motivational component: ##
The application includes a gamified mechanism that rewards users with "trees saved" and motivational messages for reducing energy consumption.
##
2. Educational Content
- Articles:
  -Accessible without an account to ensure open access
  - Filterable by category using Isotope.js
  - Interactive: users can leave comments and reviews
- Images:
  -Hover effects display short descriptions
  - Users can react with like/dislike buttons
Purpose: This section helps users understand the real consequences of excessive energy consumption and encourages behavioral change.
##
3. Personal Account
- Dashboard:
  - View energy consumption and income evolution through charts
  - Review historical calculation sessions
  - Configure personal details such as household size, income, and housing type
##
4. Admin Panel
- Separate authentication for administrators with isolated session handling
Admin functionalities:
- Manage users (block/unblock accounts)
- Add, edit, and delete articles and categories
- Moderate comments, with automatic sentiment analysis based on keywords (positive, neutral, negative)
- Manage the image gallery and descriptions
## Security feature: ## 
Password reset mechanism via MailTrap with a one-time MD5-hashed token that expires after use.

Database Notice
- The application cannot be executed online because it relies on a local database. For security and data integrity reasons, the database is not included in this repository.
