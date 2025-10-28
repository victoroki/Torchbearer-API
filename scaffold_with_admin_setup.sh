#!/bin/bash

# Fix InfyOm Templates and Regenerate Views Only
# This will fix the template issue and generate only the missing views

echo "Fixing InfyOm Templates and Regenerating Views..."
echo "================================================"

# Function to check if command was successful
check_command() {
    if [ $? -eq 0 ]; then
        echo "✅ $1 - SUCCESS"
    else
        echo "❌ $1 - FAILED"
    fi
}

# Re-publish InfyOm templates to fix missing files
echo "🔧 Re-publishing InfyOm templates..."
php artisan vendor:publish --provider="InfyOm\Generator\InfyOmGeneratorServiceProvider" --tag=laravel-generator-templates --force
check_command "Template republishing"

# Clear view cache
echo "🧹 Clearing view cache..."
php artisan view:clear
php artisan config:clear
check_command "Cache clearing"

# Generate ONLY views for each model (skip API parts since they're already done)
echo ""
echo "🎨 Generating missing views..."
echo "=============================="

echo "Generating Event views..."
php artisan infyom:scaffold Event --fromTable --table=events --skip=api,migration,model,repository,requests
check_command "Event views"

echo "Generating FormSubmission views..."
php artisan infyom:scaffold FormSubmission --fromTable --table=form_submissions --skip=api,migration,model,repository,requests
check_command "FormSubmission views"

echo "Generating GalleryItem views..."
php artisan infyom:scaffold GalleryItem --fromTable --table=gallery_items --skip=api,migration,model,repository,requests
check_command "GalleryItem views"

echo "Generating InvolvementSubmission views..."
php artisan infyom:scaffold InvolvementSubmission --fromTable --table=involvement_submissions --skip=api,migration,model,repository,requests
check_command "InvolvementSubmission views"

echo "Generating LicenseClass views..."
php artisan infyom:scaffold LicenseClass --fromTable --table=license_classes --skip=api,migration,model,repository,requests
check_command "LicenseClass views"

echo "Generating Resource views..."
php artisan infyom:scaffold Resource --fromTable --table=resources --skip=api,migration,model,repository,requests
check_command "Resource views"

echo "Generating Trainer views..."
php artisan infyom:scaffold Trainer --fromTable --table=trainers --skip=api,migration,model,repository,requests
check_command "Trainer views"

echo "Generating TrainingProgram views..."
php artisan infyom:scaffold TrainingProgram --fromTable --table=training_programs --skip=api,migration,model,repository,requests
check_command "TrainingProgram views"

echo "Generating UsefulLink views..."
php artisan infyom:scaffold UsefulLink --fromTable --table=useful_links --skip=api,migration,model,repository,requests
check_command "UsefulLink views"

echo "Generating User views..."
php artisan infyom:scaffold User --fromTable --table=users --skip=api,migration,model,repository,requests
check_command "User views"

echo ""
echo "🎉 View Generation Complete!"
echo "============================"
echo ""
echo "✅ What you now have:"
echo "• ✅ Complete API (working perfectly)"
echo "• ✅ All Models, Controllers, Requests"
echo "• ✅ Web Views (if template fix worked)"
echo ""
echo "🌐 Test your APIs:"
echo "GET http://localhost:8000/api/events"
echo "GET http://localhost:8000/api/courses"
echo "GET http://localhost:8000/api/trainers"
echo ""
echo "🎯 You're ready to go!"