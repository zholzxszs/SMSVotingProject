import 'package:flutter/material.dart';
import 'main_screen.dart';
import 'register_screen.dart';
import 'voting_results_screen.dart';

//my main.dart file
void main() {
  runApp(const VotingApp());
}

class VotingApp extends StatelessWidget {
  const VotingApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Voting App',
      theme: ThemeData(
        primarySwatch: Colors.blue,
        visualDensity: VisualDensity.adaptivePlatformDensity,
      ),
      home: const MainScreen(),
      routes: {
        '/results': (context) => VotingResultsScreen(),
        '/register': (context) => const RegisterScreen(),
      },
    );
  }
}
