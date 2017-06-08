#!/bin/bash
set -x # Show the output of the following commands (useful for debugging)

# Import the SSH deployment key
openssl aes-256-cbc -K $encrypted_a87f33a4e43c_key -iv $encrypted_a87f33a4e43c_iv -in webteam@urban-barnicle.enc -out webteam@urban-barnicle -d
rm webteam@urban-barnicle.enc # Don't need it anymore
chmod 600 webteam@urban-barnicle
mv webteam@urban-barnicle ~/.ssh/id_rsa
