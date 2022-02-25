export const getError = (error) => {
  const errorMessage = "API Error, please try again.";
  if (error.name === "Fetch User") {
    return error.message;
  }

  if (error && !error.response) {
      console.log('error', error)
    console.error(`API ${error.config.url} not found`);
    return errorMessage;
  }
  if (process.env.NODE_ENV === "development") {
    if (error && error.response) {
      console.error('data', error.response.data);
      console.error('status', error.response.status);
      console.error('headers', error.response.headers);
      // this.$notify({
      //   type: 'error',
      //   title: 'Ошибка'
      // })
    }
  }
  if (error.response.data && error.response.data.errors) {
    return error.response.data.errors;
  }

  return errorMessage;
};
