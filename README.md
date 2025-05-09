# MAKISIG RESCUE 3121 EMERGENCY ALERTING APP WITH GIS MAPPING & TRACKING SYSTEM (2019)

**Capstone Project**

MAKISIG RESCUE 3121 is an emergency alerting system designed to enhance response time and coordination for health and emergency volunteers. It is composed of two main components:

- **Laravel-based Web Application** for managing and monitoring emergency alerts.
- **Android Application** that allows users to send their real-time location during emergencies.

The system uses **Google Firebase Realtime Database** for live location updates and **Leaflet.js** for interactive GIS mapping.

> ⚠️ This project is no longer maintained and serves as an archive of my early work.

---

## 🛠️ Tech Stack

### Framework
- [Laravel](https://laravel.com/)

### Programming Languages
- PHP
- HTML / CSS / JavaScript

### Libraries & Tools
- [jQuery](https://jquery.com/)
- [Chart.js](https://www.chartjs.org/)
- [Leaflet.js](https://leafletjs.com/) – GIS Mapping

### Services
- [Firebase Realtime Database](https://firebase.google.com/products/realtime-database)
- [Vonage (formerly Nexmo)](https://www.vonage.com/) – SMS / Voice Alerts

### Database
- MySQL

### Android Application

**IDE:**
- [Android Studio](https://developer.android.com/studio)

---

## 🤖 Android Application Features
- Sends emergency alert with exact location
- Uses Firebase to push location data in real time

## 🌐 Web Application Features
- Admin dashboard to view and manage incidents
- Real-time location tracking via Firebase
- Interactive map using Leaflet.js
- Data visualization with Chart.js
- Integration with Vonage for emergency alerts

---

## 🚀 Installation (Web App)

1. **Clone the repository:**
   ```bash
   git clone https://github.com/yjaphzs/makisig_rescue_3121.git

2. Set up a virtual host (e.g., in Apache, Laragon, or Valet) pointing to the project's /public folder. Make sure you're using PHP 7.4 for the server.
Example for Apache (add to httpd-vhosts.conf):
    ```bash
    <VirtualHost *:80>
        DocumentRoot "C:/path/to/makisig_rescue_3121"
        ServerName portfolio.local
        <Directory "C:/path/to/makisig_rescue_3121/public">
            AllowOverride All
            Require all granted
        </Directory>
    </VirtualHost>

  > Ensure PHP 7.4 is set in your Apache configuration:

3. Access the site in your browser using the configured local domain:
    ```bash
    http://makisig-rescue-3121.local

---

## 📸 Screenshots
![Page2 - MR3121](https://github.com/user-attachments/assets/f42fb136-3cb5-4bf4-a10b-969ee20ec8b0)

![Page2 - MR3121 - Web](https://github.com/user-attachments/assets/ff1caa71-d702-4758-8f7a-3b792bb2ddaf)

![Page2 - MR3121 - Android App](https://github.com/user-attachments/assets/71fb8b46-befd-46da-8e15-9bdc9edbadb0)

![Page2 - MR3121 - Tools](https://github.com/user-attachments/assets/3d5636b4-9485-45ce-9a4c-57736fa6280a)

