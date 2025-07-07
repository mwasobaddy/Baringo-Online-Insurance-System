# Copilot Instructions - Baringo Online Insurance System

## Project Overview
You are building a comprehensive online insurance management system for Baringo Insurance Company in Kenya. This system will automate policy applications, renewals, payments, and management processes while providing role-based access for different user types.

## Technology Stack
- **Backend**: Laravel Framework 12.19.3
- **Frontend**: Livewire Volt v3 (component-based reactive UI)
- **Database**: MySQL 8.0+
- **Authentication**: Laravel Sanctum
- **Authorization**: Spatie Laravel Permission package
- **Animations**: GSAP (GreenSock Animation Platform)
- **Styling**: Tailwind CSS
- **Payment**: Integration with local payment gateways

## Project Structure & Conventions

### Directory Structure
```
app/
├── Http/
│   ├── Controllers/
│   ├── Middleware/
│   └── Requests/
├── Models/
├── Livewire/
├── Services/
├── Traits/
└── Enums/
resources/
├── views/
│   ├── components/
│   ├── layouts/
│   └── livewire/
├── js/
└── css/
database/
├── migrations/
├── seeders/
└── factories/
```

### Naming Conventions
- **Models**: PascalCase (e.g., `PolicyHolder`, `InsurancePolicy`)
- **Controllers**: PascalCase with "Controller" suffix (e.g., `PolicyController`)
- **Livewire Components**: PascalCase (e.g., `PolicyApplication`, `PaymentForm`)
- **Database Tables**: snake_case plural (e.g., `insurance_policies`, `policy_holders`)
- **Routes**: kebab-case (e.g., `/apply-policy`, `/payment-history`)

## Core Models & Relationships

### User Model
```php
class User extends Authenticatable
{
    // Relationships
    public function policies() // hasMany
    public function payments() // hasMany
    public function claims() // hasMany
    
    // Spatie Permission traits
    use HasRoles;
}
```

### Key Models to Create
1. **InsurancePolicy** - Core policy model
2. **PolicyType** - Types of insurance (Motor, Fire, etc.)
3. **Payment** - Payment transactions
4. **Claim** - Insurance claims
5. **Agent** - Insurance agents
6. **PolicyDocument** - Policy documents/certificates

## User Roles & Permissions

### Roles
- **policy_holder**: End users applying for insurance
- **company_official**: Insurance company staff
- **administrator**: System administrators
- **agent**: Insurance agents

### Key Permissions
- `view_policies`, `create_policies`, `update_policies`, `delete_policies`
- `process_payments`, `view_payments`
- `manage_claims`, `approve_claims`
- `generate_reports`, `view_reports`
- `manage_users`, `manage_system`

## Livewire Components Structure

### Authentication Components
- `LoginForm` - User login functionality
- `RegisterForm` - New user registration
- `PasswordReset` - Password reset functionality

### Policy Management Components
- `PolicyApplication` - Multi-step policy application form
- `PolicyList` - Display user's policies
- `PolicyDetails` - Individual policy details
- `PolicyRenewal` - Policy renewal process

### Payment Components
- `PaymentForm` - Payment processing form
- `PaymentHistory` - Payment transaction history
- `PaymentStatus` - Payment status tracking

### Dashboard Components
- `PolicyHolderDashboard` - Customer dashboard
- `CompanyOfficialDashboard` - Staff dashboard
- `AdminDashboard` - Administrator dashboard

### Report Components
- `PolicyReports` - Policy-related reports
- `FinancialReports` - Financial reporting
- `UserAnalytics` - User analytics dashboard

## Database Design Guidelines

### Core Tables
```sql
-- Users table (Laravel default with modifications)
users: id, name, email, phone, national_id, address, email_verified_at, password, remember_token, timestamps

-- Insurance policies
insurance_policies: id, user_id, policy_type_id, policy_number, status, start_date, end_date, premium_amount, coverage_amount, created_at, updated_at

-- Policy types
policy_types: id, name, description, base_premium, coverage_details, created_at, updated_at

-- Payments
payments: id, user_id, policy_id, amount, payment_method, transaction_id, status, paid_at, created_at, updated_at

-- Claims
claims: id, user_id, policy_id, claim_number, description, amount_claimed, status, submitted_at, processed_at, created_at, updated_at
```

### Relationships
- User hasMany Policies
- Policy belongsTo User, PolicyType
- Payment belongsTo User, Policy
- Claim belongsTo User, Policy

## Development Guidelines

### Code Quality
- Follow PSR-12 coding standards
- Use type declarations for all methods
- Implement proper error handling with try-catch blocks
- Add comprehensive comments for complex logic
- Use Laravel's built-in validation rules

### Security Best Practices
- Validate all user inputs
- Use CSRF protection on all forms
- Implement rate limiting on authentication routes
- Sanitize data before database operations
- Use parameterized queries (Eloquent ORM)

### Performance Optimization
- Use database indexes on frequently queried columns
- Implement caching for expensive operations
- Use lazy loading for relationships
- Optimize database queries with eager loading
- Implement pagination for large datasets

## Livewire Volt Implementation

### Component Structure
```php
<?php
use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Rule};

new class extends Component {
    #[Rule('required|string|max:255')]
    public string $name = '';
    
    public function save()
    {
        $this->validate();
        // Implementation
    }
}; ?>

<div>
    <!-- Component HTML -->
</div>
```

### State Management
- Use public properties for form data
- Implement validation using attributes
- Handle form submissions with dedicated methods
- Use Livewire's reactive properties for real-time updates

## GSAP Animation Guidelines

### Animation Principles
- Use subtle, purposeful animations
- Implement loading states with smooth transitions
- Animate form submissions and state changes
- Create smooth page transitions
- Use GSAP timeline for complex animations

### Common Animation Patterns
```javascript
// Fade in animation
gsap.from('.fade-in', {duration: 1, opacity: 0, y: 20});

// Loading spinner
gsap.to('.spinner', {duration: 1, rotation: 360, repeat: -1, ease: 'none'});

// Form validation feedback
gsap.to('.error-message', {duration: 0.3, opacity: 1, scale: 1});
```

## Payment Integration

### Local Payment Gateways
- Implement M-Pesa integration for mobile payments
- Support Airtel Money and other local providers
- Handle payment callbacks and webhooks
- Implement payment status tracking

### Payment Flow
1. User selects payment method
2. System calculates total amount
3. Redirect to payment gateway
4. Handle payment response
5. Update payment status
6. Send confirmation notifications

## API Design (if needed)

### RESTful Endpoints
- `GET /api/policies` - List user policies
- `POST /api/policies` - Create new policy
- `GET /api/policies/{id}` - Get specific policy
- `PUT /api/policies/{id}` - Update policy
- `POST /api/payments` - Process payment

### Response Format
```json
{
    "success": true,
    "data": {},
    "message": "Operation successful",
    "errors": []
}
```

## Testing Strategy

### Test Types
- **Feature Tests**: Test complete user workflows
- **Unit Tests**: Test individual methods and classes
- **Browser Tests**: Test JavaScript interactions
- **API Tests**: Test API endpoints

### Test Coverage
- Authentication and authorization
- Policy application process
- Payment processing
- Report generation
- User role permissions

## Deployment Considerations

### Environment Variables
```env
APP_NAME="Baringo Insurance System"
APP_ENV=production
APP_DEBUG=false
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=baringo_insurance
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls

MPESA_CONSUMER_KEY=
MPESA_CONSUMER_SECRET=
MPESA_SHORTCODE=
```

### Production Optimizations
- Enable caching (config, routes, views)
- Use queue workers for background jobs
- Implement proper logging
- Set up monitoring and alerting
- Configure backup strategies

## Documentation Requirements

### Code Documentation
- Document all public methods
- Include parameter and return type descriptions
- Add usage examples for complex components
- Document business logic and calculations

### User Documentation
- Create user manuals for each role
- Provide step-by-step guides for common tasks
- Include troubleshooting sections
- Document API endpoints if applicable

## Error Handling

### Exception Handling
- Use specific exception classes
- Implement custom exception handlers
- Log all errors for debugging
- Provide user-friendly error messages

### Validation Messages
- Provide clear, actionable error messages
- Use localization for multi-language support
- Implement real-time validation feedback
- Handle server-side validation errors

## Accessibility Guidelines

### WCAG Compliance
- Use semantic HTML elements
- Implement proper ARIA labels
- Ensure keyboard navigation support
- Maintain sufficient color contrast
- Provide alternative text for images

### Responsive Design
- Mobile-first approach
- Touch-friendly interface elements
- Optimized performance on mobile devices
- Consistent user experience across devices

## Monitoring & Maintenance

### Performance Monitoring
- Track page load times
- Monitor database query performance
- Implement error tracking
- Set up uptime monitoring

### Regular Maintenance
- Schedule database backups
- Update dependencies regularly
- Monitor security vulnerabilities
- Perform regular performance audits

## Common Development Patterns

### Service Classes
Create service classes for complex business logic:
```php
class PolicyService
{
    public function createPolicy(array $data): InsurancePolicy
    {
        // Policy creation logic
    }
    
    public function calculatePremium(PolicyType $type, array $factors): float
    {
        // Premium calculation logic
    }
}
```

### Event Handling
Use Laravel events for system notifications:
```php
event(new PolicyCreated($policy));
event(new PaymentProcessed($payment));
event(new ClaimSubmitted($claim));
```

### Queue Jobs
Implement background jobs for time-consuming tasks:
```php
class SendPolicyNotification implements ShouldQueue
{
    public function handle()
    {
        // Send notification logic
    }
}
```

This comprehensive guide should help you build a robust, secure, and scalable online insurance management system. Focus on creating a user-friendly interface with proper error handling and security measures throughout the development process.