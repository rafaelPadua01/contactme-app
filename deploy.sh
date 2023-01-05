#!/usr/bin/env/ sh 

# abort on errors 
set -e

#build 
npm run build 

# navigate to the build output directory
cd dist

# place .nojekyll to bypass Jekyll ṕrocess
echo > .nojekyll

# if deploy in custom domain
# echo 'www.example.com' > CNAME

git init 
git checkout -B main
git add -A
git commit -m 'deploy-2023-01-05'

#if deploy  to HTTPS://USERNAME.github.io
# git push -f git@github.com:<USERNAME>/<USERNAME>.github.io.git main

#if deploy to https://<USERNAME>.github.io/<REPO>
#git push -f git@github.com:<USERNAME>/<REPO>.git main:gh-pages

cd - 