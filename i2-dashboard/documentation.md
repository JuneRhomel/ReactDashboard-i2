# Project Documentation: React i2

## Table of Contents

1. [Introduction](#introduction)
2. [Project Overview](#project-overview)
3. [Installation](#installation)
4. [Folder Structure Overview](#folder-structure-overview)
5. [Naming Conventions and Code Styling](#naming-conventions-and-code-styling)
6. [Dependencies](#dependencies)
7. [Routing](#routing)
8. [Components](#components)
    - [Button Component](#button-component)
    - [Cards](#cards)
        - [PaymentCard Component](#paymentcard-component)
        - [ServiceRequestCard Component](#servicerequestcard-component)
        - [SoaCard Component](#soacard-component)
    - [DropdownForm](#dropdownform)
    - [InputGroup](#inputgroup)
    - [Layout](#layout)
9. [Pages](#pages)
10. [State Management](#state-management)
11. [API Structure](#api-structure)
    - [Pages API](#pages-api)
    - [Utils API](#utils-api)
12. [Environment Variable Accessability](#environment-variable-accessibility)
13. [Authentication Customization](#authentication-customization)
14. [Deployment](#deployment)
    - [Vercel Deployment Process](#vercel-deployment-process)
    - [Deployment Platform Considerations](#deployment-platform-considerations)
    - [Deployment Best Practices](#deployment-best-practices)

---

### Introduction

We're transitioning from conventional [PHP](https://www.php.net/) to an advanced React application driven by [TypeScript](https://www.typescriptlang.org/) and [Next.js](https://nextjs.org/) framework. This project focuses on building the i2 user portal in a robust React Next.js environment. Our primary goal is to create a benchmark for future Inventi projects.

Our mission centers on fostering component reusability and defining standardized API responses. This approach accelerates the development of new features while ensuring consistency across functionalities.

### Project Overview

Our transition from vanilla PHP to a React application using TypeScript and Next.js introduces the React-i2 user portal. While predominantly front-end focused, we've implemented sound RESTful principles in a pseudo-backend. This backend facilitates communication with the existing external PHP backend through cross-origin requests over the internet.

#### Key Features:

- **Component Reusability:** Emphasis on building modular, reusable components to streamline development.
- **Standardized API Responses:** Ensuring a consistent format for API data to facilitate rapid feature integration.

#### Technology Stack:

- **Frontend:** React, TypeScript
- **Backend:** Existing PHP backend and SQL Database
- **Framework:** Next.js

#### Backend Integration:

The project's pseudo-backend acts as a bridge to the external PHP backend, making cross-origin requests for data. This may affect performance compared to the native PHP version due to network overhead.

#### Future Development:

To optimize performance, future iterations might involve crafting a dedicated backend using Next.js Backend API. This would mitigate cross-origin request delays and potentially enhance overall system efficiency.

#### Current Data Fetch Mechanism:

Presently, every data fetch request via the project's API involves making direct fetch calls to the existing PHP backend.

### Installation

Follow these steps to set up the project locally:

#### Prerequisites

- [Node.js](https://nodejs.org/) (version 20.5.1 or higher)
- [npm](https://www.npmjs.com/) or [Yarn](https://yarnpkg.com/)

#### Steps

1. **Clone the repository:**

    ```
    git clone https://github.com/kevinngkaion/ReactDashboard-i2.git
    ```

2. **Navigate to the project directory:**

    ```
    cd ReactDashboard-i2
    ```

3. **Set up Environment Variables:**

    - Create a file named `.env.local` in the project's root directory.

    - To configure the necessary environment variables, open or create a file named `.env.local` in the project's root directory.
  
    If you don't have the values for these environment variables, please reach out to your system administrator or manager for assistance in obtaining them:

        ```
        API_URL
        API_SECRET
        API_ID
        TEST_ACCOUNT_CODE
        JWT_SECRET
        SECRET_KEY
        ```
    
    These environment variables are necessary for the project and might be required for future functionalities.

4. **Install dependencies:**

    ```
    npm install   # or yarn install
    ```

5. **Start the development server:**

    ```
    npm run dev   # or yarn dev
    ```

6. **Access the application:**

    Open your browser and visit `http://localhost:3000` to view the application.

### Folder Structure Overview

The project's folder structure primarily includes the following key files and folders:

```
i2-dashboard/
│
├── .next/                  # Next.js build output (auto-generated)
├── components/             # Reusable components
│   ├── pages/              # Page components rendered when a page is hit
│   └── globals.css         # Global CSS styles
├── context/                # Context related files
├── node_modules/           # Node.js dependencies (auto-generated)
├── pages/                  # Next.js pages
│   └── api/                # Server-side API
│       ├── requests/       # Directory for requests (within pages/api)
│       └── user/           # Directory for user-related functionalities (within pages/api)
├── public/                 # Static assets
├── types/                  # Type definition files
└── utils/                  # Utility functions or helper files
    └── api/                # Main API functions for data retrieval and processing
        ├── requests/       # Directory for requests (within utils/api)
        ├── soa/            # Directory for SOA
        ├── user/           # Directory for user-related functionalities (within utils/api)
        └── index.ts        # Exported as the api object

```

### Naming Conventions and Code Styling

Consistent naming conventions and code styling foster readability and maintainability across the project. Adhering to established guidelines ensures uniformity in the codebase and simplifies collaboration among team members. Here are the conventions followed in this project:

#### 1. File and Folder Naming

- **/pages Directory:** All files inside the `/pages` directory should be in all lowercase.
- **Components:** Component names should be in ProperCase.
- **Other Files and Folders:** Use camelCase for everything else.

#### 2. CSS Styling

- **camelCase:** Use camelCase for all CSS naming conventions.

#### 3. Descriptive Naming

- **Descriptive:** All names should be descriptive and avoid unnecessary abbreviations. Aim for clarity and readability; for instance, prefer `userContact` over `userNo`.

#### 4. Commenting and Documentation

- **JSDoc Standards:** Utilize JSDoc comments for functions to describe parameters, return types, and usage guidelines. For example:

```typescript
/** 
* Fetches all the user's Service Issues
* @param {ParamGetServiceRequestType} params - JSON object with accountCode, queryCondition, and resultLimit
* @return {Promise<ApiResponse<ServiceIssueType[]>>} Promise of a Response object.
*/
```
Adhering to these conventions streamlines the development process, promotes code quality, and enhances the project's maintainability and scalability.

### Dependencies

This project utilizes several key dependencies and tools:

- **Next.js:** React framework for server-rendered applications. Version: 13.4.19
- **React:** JavaScript library for building user interfaces. Version: 18.2.0
- **TypeScript:** Typed JavaScript for enhanced developer experience. Version: 5.2.2
- **bcrypt:** Library for hashing passwords. Version: 5.1.1
- **classnames:** Utility for managing CSS class names. Version: 2.3.2
- **crypto-js:** Library for cryptographic functions. Version: 4.2.0
- **jsonwebtoken:** Library for creating and validating JSON Web Tokens. Version: 9.0.2
- **react-dom:** React package for DOM rendering. Version: 18.2.0
- **react-icons:** Library for icons in React. Version: 4.10.1

#### Dev Dependencies

- **eslint:** Tool for identifying and reporting on patterns found in JavaScript code. Version: 8.48.0
- **eslint-config-next:** ESLint configuration for Next.js projects. Version: 13.4.19
- **@types/bcrypt:** TypeScript definitions for bcrypt. Version: 5.0.0
- **@types/node:** TypeScript definitions for Node.js. Version: 20.5.9
- **@types/react:** TypeScript definitions for React. Version: 18.2.21
- **@types/react-dom:** TypeScript definitions for React DOM. Version: 18.2.7
- **@types/crypto-js:** TypeScript definitions for crypto-js. Version: 4.1.3
- **@types/jsonwebtoken:** TypeScript definitions for jsonwebtoken. Version: 9.0.3

These dependencies are managed via `npm` or `Yarn` and can be found in the `package.json` file.

### Routing

This project primarily utilizes traditional routing with get parameters.

- **Get Parameters:** Routes within the application often rely on get parameters for passing data. For instance, routes like `/viewsoa?id=1` are used to fetch specific data based on the provided parameters.
- **No Dynamic Routes:** The project currently doesn't implement dynamic routes using Next.js' square bracket notation (`[]`). This can be added later without extra configuration
- **No Custom Route Handling:** There are no custom route handling implementations within the `pages` directory or custom API routes.

While the current implementation revolves around get parameters, Next.js supports more advanced routing techniques like dynamic routes and custom route handling, which can be incorporated later as needed.


### Components
Document commonly used components, their props, and functionalities.

#### Button

The `Button` component is a reusable element responsible for rendering various types of buttons with specific functionalities based on the `type` prop.

##### Props
- **type**: Represents the type of button to render. Accepted values:
  - `'back'`: Renders a button with a left chevron icon (from `react-icons/fa6`) to signify a back navigation.
  - `'Item Details'`, `'Guest List'`, `'List of Workers/Personnel'`, `'List of Materials'`, `'List of Tools'`: Renders buttons with specific text to add corresponding items.
  - `'submit'`: Renders a button labeled "Submit".
  - `'cancel'`: Renders a button labeled "Cancel".
- **onClick**: Callback function executed on button click.

##### Button Content
The button content is determined based on the `type` prop using a `Map` object:

```javascript
const buttonContent = new Map([
  ['back', <FaChevronLeft key={'faChevronLeftKey'}/>],
  ['Item Details', '+ Add Item'],
  ['Guest List', '+ Add Guest'],
  ['List of Workers/Personnel', '+ Add Workers/Personnel'],
  ['List of Materials', '+ Add Materials'],
  ['List of Tools', '+ Add Tools'],
  ['submit', 'Submit'],
  ['cancel', 'Cancel'],
]);
```
##### Styling

The `Button` component utilizes CSS modules for styling. Different button styles are applied based on the `type` prop, using classNames derived from the `styles` object.

##### Usage

Example usage of the `Button` component:

```javascript
import Button from './components/general/button';

// Inside JSX
<Button type="submit" onClick={handleSubmit} />
```

##### Notes

The `Button` component:

- Includes conditional rendering based on the `type` prop to display the appropriate button content.
- Utilizes classNames to apply specific styles, such as an 'addItem' class for buttons prefixed with '+', denoting an addition action.

##### CSS

The `Button` component leverages CSS modules for styling. Different button styles are applied based on the `type` prop, utilizing classNames derived from the `styles` object.

#### Cards
Different kinds of cards are utilized:
- `paymentCard`
- `serviceRequestCard`
- `soaCard`

#### PaymentCard Component

##### Overview
The `PaymentCard` component is responsible for rendering payment transaction details in a card format.

##### Location
The `PaymentCard` component is located at the designated path for payment cards.

##### Props
- **transaction**: Accepts an object of type `SoaPaymentsType` representing the payment transaction details.

##### Implementation Details
The component utilizes CSS modules for styling and formats the payment details to display within the card.

##### Styling
The card's appearance is influenced by the transaction's status:
- **Invalid**: Applied styles when the transaction status is 'Invalid'.
- **For Verification**: Styles utilized for transactions under verification.
- **Successful**: Styles for transactions marked as successful.

##### Structure
The rendered card consists of:
- A section indicating the transaction status.
- Details such as transaction particular, date, and payment type.
- The transaction amount formatted using `formatCurrency` function.

##### Example Usage
Import the PaymentCard component:

```javascript
import { PaymentCard } from '[root]/components/general/cards/paymentCard/PaymentCard'; // Import the PaymentCard component

// Inside JSX, pass the transaction object to PaymentCard
<PaymentCard transaction={transactionData} />
```
##### Note
- The component dynamically applies styles based on the transaction status for visual representation.
- It formats and displays transaction details within a styled card format.

These cards display specific details based on their types.

#### ServiceRequestCard Component

##### Overview
The `ServiceRequestCard` component renders specific details based on the type of service request provided. It includes functionality to display different components such as reports, gate passes, work permits, or visitor passes.

##### Props
- **request**: Represents a ServiceRequestType or ServiceRequestDataType object.
- **variant**: (Optional) Specifies the variant type such as 'Report Issue', 'Gate Pass', 'Work Permit', or 'Visitor Pass'. Defaults to `undefined`.

##### Implementation Details
The component utilizes various sub-components based on the `variant` or the type of data passed. It relies on a Map to render specific components according to the `variant`.

##### Sub-components
- **ServiceIssue**: Renders service issue details based on a ServiceIssueType object.
- **Gatepass**: Displays gate pass information using a GatepassType object.
- **WorkPermit**: Exhibits work permit details derived from a WorkPermitType object.
- **VisitorPass**: Shows visitor pass specifics from a VisitorsPassType object.

##### Usage
Example usage:
```javascript
import { ServiceRequestCard } from './path/to/ServiceRequestCard'; // Import the ServiceRequestCard component

// Inside JSX, pass the request object to ServiceRequestCard
<ServiceRequestCard request={requestData} variant="Report Issue" />
```

##### Note
- The `ServiceRequestCard` component dynamically renders sub-components based on the `variant` or the type of request data provided.
- It incorporates a StatusBubble component to display the status of the request.
- The `dateUpload` property is utilized to indicate the date of the request.

#### SoaCard Component

##### Overview
The `SoaCard` component renders details associated with a Statement of Account (SOA). It displays information like the statement's status, date, due date, total amount due, and offers an option to view additional details.

##### Props
- **currentSoa**: Represents a SoaType object containing details of the current statement of account.
- **currentSoaPayments**: An array of SoaPaymentsType objects containing payment details related to the current statement.
- **children**: (Optional) Additional content or components to render within the SoaCard component.

##### Implementation Details
The component employs CSS modules for styling and computes various details such as the statement date, due date, statement amount, and applied credits towards the statement amount.

##### Usage
Example usage:

Import the SoaCard component:
```javascript
import { SoaCard } from './path/to/SoaCard'; // Import the SoaCard component

// Inside JSX, pass currentSoa and currentSoaPayments to SoaCard
<SoaCard currentSoa={currentSoaData} currentSoaPayments={currentPaymentsData}>
  {/* Additional children or content */}
</SoaCard>
```

##### Note
- The `SoaCard` component dynamically calculates the amount due based on payment details and displays it accordingly.
- Clicking "View Details" redirects to a page for viewing specific SOA details.
- The `children` prop allows for the insertion of additional content or components within the SoaCard.


#### DropdownForm

##### Overview
The `DropdownForm` component creates a dropdown functionality to display forms or content. It manages the visibility of the dropdown and renders the provided content as a form or other relevant data within it.

##### Props
- **children**: Accepts the form or content to be displayed within the dropdown.

##### Implementation Details
The component utilizes CSS modules for styling. It maintains an internal state to manage the visibility of the dropdown. When clicked, it toggles the display of the content within the dropdown.

##### Usage
Example usage:

Import the DropdownForm component:
```javascript
import DropdownForm from './path/to/DropdownForm'; // Import the DropdownForm component

// Inside JSX, pass the form or content to be displayed within the dropdown
<DropdownForm>
  {/* Add the form or content here */}
</DropdownForm>
```
##### Note
- The `DropdownForm` component simplifies the creation of a dropdown and allows for easy rendering of forms or content within it.
- It manages the visibility state and toggles the display of the content based on user interaction.


#### InputGroup

##### Overview
The `InputGroup` component renders various types of inputs based on the provided `InputProps`. It dynamically selects and renders different input components such as password, select, text area, or standard input based on the given type.

##### Props
- **props**: Represents an `InputProps` object containing input-related properties.
- **onChange**: Receives a `ChangeEventHandler` function for handling input changes.

##### Implementation Details
The component uses a mapping technique to associate input types with corresponding input components. Based on the `props.type`, it selects and renders the appropriate input component.

##### Usage
Example usage:

Import the InputGroup component:
```javascript
import InputGroup from './path/to/InputGroup'; // Import the InputGroup component

// Inside JSX, pass InputProps and onChange function to InputGroup
<InputGroup props={inputPropsData} onChange={handleInputChange} />
```
##### Note
- The `InputGroup` component efficiently manages various input types and renders the corresponding input components accordingly.
- It handles input changes via the provided `onChange` function.
- The component's appearance can be altered based on the `disabled` property in the `InputProps`.


#### Layout

##### Overview
The `Layout` component serves as the main layout structure for the application, incorporating navigation, header, and content areas based on the current route.

##### Props
- **children**: Represents the child components or content to be displayed within the layout.
- **title**: Denotes the title of the layout.

##### Implementation Details
The component dynamically adjusts the layout structure based on the current route using the `NextRouter` from Next.js. If the route is the home ('/'), it renders only the children; otherwise, it includes the `Header`, a container for the children, and the `Navigation`.

##### Usage
Example usage:

Import the Layout component:
```javascript
import Layout from './path/to/Layout'; // Import the Layout component

// Inside JSX, pass children and title to Layout
<Layout title="Page Title">
  {/* Add the content or child components here */}
</Layout>
```

##### Note
- The `Layout` component manages the overall structure of the application based on the current route, rendering different components accordingly.
- It configures the title and favicon for each page using the `Head` component from Next.js.

### Pages

1. **Home (`/`):** Redirects to login if the user is not logged in, otherwise goes to the dashboard.
2. **Dashboard (`/dashboard`):** Main dashboard page.
3. **SOA (`/soa`):** Displays the current statement of account and recent transactions.
4. **View SOA (`/viewsoa`):** Shows details of the current statement of account and provides payment options.
5. **My Requests (`/myrequests`):** Displays service requests made by the user and allows creation of new service requests.
6. **Select Service Request (`/selectservicerequest`):** Page to select or create service requests.
7. **Report Issue (`/reportissue`):** Displays and filters service issue requests and allows creation of new requests.
8. **Work Permit (`/workpermit`):** Displays and filters work permit requests and allows creation of new requests.
9. **Visitor Pass (`/visitorpass`):** Displays and filters visitor pass requests and allows creation of new requests.
10. **Gatepass (`/gatepass`):** Displays and filters gatepass requests and allows creation of new requests.
11. **Login (`/login`):** Login page for users.
12. **Logout (`/logout`):** Logs out the user and redirects to the index page upon success.
13. **News & Announcement (`/newsannouncement`):** Displays news and announcements for the building.


### State Management

This project utilizes various React hooks for state management:

- **useState:** Employed for managing local component-level state.
- **useEffect:** Used for handling side effects in components.
- **useUserContext:** Custom hook created to manage and provide global access to the logged-in user information. This hook requires invocation in each top-level component (components with names corresponding to routes) to set the user, enabling global accessibility of user data when a user is logged in.

These hooks collectively manage the state within components and handle side effects, providing a mechanism for local and global state management without the need for external state management libraries.

### API Structure

This project relies on an existing PHP backend API for data retrieval and processing, employing cross-origin requests through the internet for communication.

#### `pages/api`

- **Purpose:** Next.js server-side API accessible via `[projectBaseUrl]/api/[apiEndPoint]`.
- **Functionality:** Handles cross-origin fetch requests to the PHP backend for data retrieval and server-side functionalities.
- **Usage Guidelines:** Reserved for server-side functionalities; any serverside operations or interactions with the existing PHP backend API are implemented here.

#### `utils/api`

- **Purpose:** Main API functions dedicated to data retrieval and processing.
- **Functionality:** Contains functions responsible for fetching data from the PHP backend and processing it for use within different project pages.
- **Data Processing:** The processing of fetched data from the PHP backend is conducted here to prepare it for consumption in various application sections.
- **API Function Structure:**
  - Each API function follows a specific structure:
    - Params:
      - `RequestParams`: Parameters necessary for making the API request.
      - `token` (Optional): User token for authentication.
      - `context` (Optional): Contextual information.
    - Returns: An `ApiResponse<T>` object containing the response data.
  - `ApiResponse` Type: A pre-defined structure for API responses, ensuring consistency in the response format across API functions.
  - **JSDocs Documentation:** Detailed JSDocs have been provided for each API function, enabling usage descriptions and guidance within compatible IDEs or code editors like VSCode.

Example API function:

- `getIssueCategories(token = "c8c69a475a9715c2f2c6194bc1974fae:tenant", context = undefined)`: Fetches the options for issue categories.
  - **Params:**
    - `token`: User token (Optional).
    - `context`: Contextual information (Optional).
  - **Returns:** An `ApiResponse` object containing the response data.

The `ApiResponse` type, pre-defined in a separate file, structures the response format for each API function within `utils/api`, ensuring consistency and clarity in the response data structure.

Example of Successful API Response:
```typescript
{
    success: false,
    data: {
        id: '874',
        residentId: '1',
        monthOf: '8',
        yearOf: '2023',
        balance: '2612.00',
        chargeAmount: '1000.00',
        electricity: '375.00',
        water: '12.00',
        cusa: '250.00',
        assoDues: '1234.00',
        currentCharges: '2871.00',
        amountDue: '5483.00',
        notes: null,
        status: 'For Verification',
        posted: '0',
        createdBy: '1',
        createdOn: '1699190510',
        deletedBy: '0',
        deletedOn: '0',
        dueDate: '2023-09-12',
        residentName: 'Admin De Vera',
        companyName: 'Company 1',
        unitName: 'Unit 101',
        unitId: '5',
        locationName: 'Ground Floor',
        floorArea: '11',
        locationType: 'Unit',
        encId: 'U2FsdGVkX1%2BKcyvW09OYdaIRtsycG7tPRqw8sO3es%2Bc%3D'
    },
    error: undefined
}
```
Example of Unsuccessful Api Response:
```typescript
{
    success: false,
    data: undefined,
    error: "400 Bad Request! SQLSTATE[42S02]: Base table or view not found: 1146 Table 'otsi2_1.vw_ssoa' doesn't exist"
}
```

This project structure emphasizes a separation of concerns, utilizing `pages/api` for server-side operations and cross-origin fetch requests to the existing PHP backend API. Meanwhile, `utils/api` houses functions responsible for data processing and preparation retrieved from the PHP backend for usage across the application.

### Environment Variable Accessibility

In this project, environment variables serve as crucial configuration settings. However, it's important to note their accessibility and usage within different contexts:

#### Server-side vs. Client-side Access

Environment variables in this application can only be accessed during server-side functions and processes. Any operation performed on the client-side lacks direct access to these environment variables.

#### API Directories and Variable Access

- **`/pages/api`:** This directory is capable of accessing environment variables at any time. The API functions created within this directory can directly call upon environment variables.
  
- **`/utils/api`:** The functions within this directory can only access environment variables when invoked by `getServerSideProps`. As these functions execute on the server-side, they inherit the ability to retrieve environment variables.

The separation into these directories ensures that sensitive configuration details remain secure, accessible only within server-side functionalities, thereby enhancing the overall application security.

It's crucial to structure client and server-side functionalities while considering these limitations in environment variable accessibility.

### Authentication Customization

In this project, authentication diverges from the standard PHP version, utilizing a custom approach due to constraints posed by the Next.js environment's lack of direct access to sessions. Instead, a JWT (JSON Web Token) is employed and stored as a browser cookie named 'token'.

- **Token Handling:** The JWT token, named 'token', is generated and signed within the `/api/user/authenticate` endpoint, with a default expiration set to 1 day (modifiable).
- **Authentication Flow:**
  - User login through the login form triggers a submission, e.g. `const response = api.user.authenticate(formData)`.
  - Inside `utils/api/user/authenticate`, the request data is structured with necessary headers and building's account code, initiating a fetch request to `/api/user/authenticate`.
  - `/api/user/authenticate` forwards the request data to the external PHP backend. Upon successful authentication:
    - A User object is created and stored in a JWT.
    - The JWT is set as a cookie in the browser.
    - A 200 response containing the User object redirects to the login form, subsequently redirecting to the dashboard.
  - Failed authentication results in an appropriate error response, with no JWT creation or user login.
- **Logout Handling:** Logging out triggers the deletion of the 'token' cookie, effectively terminating the user's session.
- **Customization:** Custom JWT parameters, expiration settings, and error handling can be modified based on specific project needs.
- **Access Control:** The JWT token facilitates access control across protected routes, ensuring authorized access to authenticated users while maintaining a secure login flow.

### Deployment

The project is presently deployed on Vercel, although the ultimate deployment platform for live production is at the discretion of the client, Inventi.

#### Vercel Deployment Process

The live version on Vercel is synchronized with the main branch of the project repository. To deploy updates:

1. **Updating the Project:** Push the updates to the main branch of the repository.
2. **Environment Variables:** Ensure that any necessary environment variables within Vercel are updated accordingly.

#### Deployment Platform Considerations

While the current deployment is on Vercel, the flexibility remains to choose an alternate platform for live production deployment. Considerations for deployment platforms include:

- **Ease of Integration:** Assess how well the platform integrates with Next.js projects.
- **Customization:** Evaluate customization options for environment variables, build configurations, and deployment workflows.
- **Scalability and Performance:** Ensure the chosen platform can accommodate scaling requirements and offers optimal performance.

#### Deployment Best Practices

- **Automation:** Consider implementing CI/CD pipelines for automated deployments on each repository update or commit.
- **Testing and Monitoring:** Prioritize comprehensive testing post-deployment and ongoing monitoring to ensure the application's functionality and performance.

It's imperative to refer to specific platform documentation for detailed deployment procedures and to adhere to any client-specific preferences or requirements.