# CONFIGURACION - Solo modifica esta linea:
$DB_PASSWORD = "woptqoou"

# ===== NO MODIFICAR A PARTIR DE AQUI =====
$DB_USER = "postgres"
$DB_NAME = "HuAviar"
$BACKUP_FILE = "huaviar_backup.sql"

Write-Host ""
Write-Host "Paso 1: Exportando BD local HuAviar..." -ForegroundColor Cyan
$env:PGPASSWORD = $DB_PASSWORD
pg_dump -U $DB_USER -d $DB_NAME -F p -f $BACKUP_FILE
Remove-Item Env:\PGPASSWORD

if (!(Test-Path $BACKUP_FILE)) {
    Write-Host "Error: No se pudo crear el backup" -ForegroundColor Red
    exit 1
}

$fileSize = (Get-Item $BACKUP_FILE).Length / 1KB
Write-Host "Backup creado: $BACKUP_FILE ($([math]::Round($fileSize, 2)) KB)" -ForegroundColor Green

Write-Host ""
Write-Host "Paso 2: Levantando Docker..." -ForegroundColor Cyan
docker-compose up -d

Write-Host ""
Write-Host "Paso 3: Esperando que PostgreSQL inicie..." -ForegroundColor Yellow
Start-Sleep -Seconds 5

Write-Host ""
Write-Host "Paso 4: Copiando backup al contenedor..." -ForegroundColor Cyan
docker cp $BACKUP_FILE laravel_postgres:/tmp/backup.sql

Write-Host ""
Write-Host "Paso 5: Importando base de datos..." -ForegroundColor Cyan
docker exec -i laravel_postgres psql -U laravel_user -d si1_db -f /tmp/backup.sql 2>&1

Write-Host ""
Write-Host "Paso 6: Verificando tablas importadas..." -ForegroundColor Cyan
docker exec -i laravel_postgres psql -U laravel_user -d si1_db -c "\dt"

Write-Host ""
Write-Host "Paso 7: Verificando tabla fotoaves..." -ForegroundColor Cyan
docker exec -i laravel_postgres psql -U laravel_user -d si1_db -c "SELECT COUNT(*) as total_fotos FROM fotoaves;"

Write-Host ""
Write-Host "Paso 8: Limpiando archivos temporales..." -ForegroundColor Cyan
docker exec -i laravel_postgres rm /tmp/backup.sql

Write-Host ""
Write-Host "Paso 9: Reiniciando Laravel..." -ForegroundColor Cyan
docker-compose restart app

Write-Host ""
Write-Host "Migracion completada exitosamente!" -ForegroundColor Green
Write-Host ""
Write-Host "Proximos pasos:" -ForegroundColor Yellow
Write-Host "   1. Accede a pgAdmin: http://localhost:8081" -ForegroundColor White
Write-Host "   2. Accede a Laravel: http://localhost:8000" -ForegroundColor White
Write-Host "   3. Verifica tu .env tenga:" -ForegroundColor White
Write-Host "      DB_HOST=postgres" -ForegroundColor Gray
Write-Host "      DB_PORT=5432" -ForegroundColor Gray
Write-Host "      DB_DATABASE=si1_db" -ForegroundColor Gray
Write-Host "      DB_USERNAME=laravel_user" -ForegroundColor Gray
Write-Host "      DB_PASSWORD=laravel_password" -ForegroundColor Gray
Write-Host ""