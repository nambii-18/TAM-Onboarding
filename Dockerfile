FROM mattrayner/lamp:latest-1804
# RUN rm -fr /app && git clone https://github.com/username/customapp.git /app
EXPOSE 80 3306
CMD ["/run.sh"]