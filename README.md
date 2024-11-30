# Photest

A simple PHP task management application with Docker support.

## Requirements

- Docker
- Docker Compose

## Local Development

1. Clone the repository:
```bash
git clone https://github.com/YOUR_USERNAME/photest.git
cd photest
```

2. Start the containers:
```bash
docker compose up -d
```

3. Access the application at `http://localhost:8080`

## Deployment with EasyPanel

1. Create a new service in EasyPanel
2. Select PHP Preset
3. Configure the following environment variables:
   - MYSQL_HOST=db
   - MYSQL_DATABASE=photest
   - MYSQL_USER=photest_user
   - MYSQL_PASSWORD=your_secure_password
   - MYSQL_ROOT_PASSWORD=your_secure_root_password

4. Deploy and enjoy!
