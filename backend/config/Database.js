import { Sequelize } from 'sequelize';

const db = new Sequelize('kwhproject', 'username', 'password', {
  host: 'localhost',
  dialect: 'mysql'
});

export default db;